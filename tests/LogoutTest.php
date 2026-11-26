<?php

namespace RwandaBuild\MurugoAuth\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
use RwandaBuild\MurugoAuth\Facades\MurugoAuth;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use RwandaBuild\MurugoAuth\MurugoAuthHandler;

/** MurugoAuth::logout(): SSO logout through Murugo (POST /api/thirdparty-sso-logout) */
class LogoutTest extends TestCase
{
    private array $sent = [];

    private function murugo(array $responses): void
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->sent));
        MurugoAuthHandler::useHttpClient(new Client(['handler' => $stack]));
    }

    protected function tearDown(): void
    {
        MurugoAuthHandler::useHttpClient(null);
        parent::tearDown();
    }

    private function user(?string $refreshToken = 'rt-1'): MurugoUser
    {
        return MurugoUser::create([
            'name' => 'ana', 'murugo_user_id' => 'h-1', 'token' => 'at-1',
            'refresh_token' => $refreshToken, 'token_expires_at' => now()->addHour(),
        ]);
    }

    private function assertTokensCleared(MurugoUser $user): void
    {
        $fresh = $user->fresh();
        $this->assertSame('', $fresh->token);
        $this->assertNull($fresh->refresh_token);
        $this->assertNull($fresh->token_expires_at);
    }

    public function test_logout_calls_murugo_with_the_users_token_and_app_key_and_clears_tokens()
    {
        $this->murugo([new Response(200, [], '{"success":true,"murugo_session_ended":true}')]);
        $user = $this->user();

        $this->assertTrue(MurugoAuth::logout($user));

        $this->assertCount(1, $this->sent);
        $request = $this->sent[0]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://murugo.test/api/thirdparty-sso-logout', (string) $request->getUri());
        $this->assertSame('Bearer at-1', $request->getHeaderLine('Authorization'));
        $this->assertSame('app-key', $request->getHeaderLine('APPKEY'));
        $this->assertTokensCleared($user);
    }

    public function test_expired_token_is_refreshed_once_then_logout_retried()
    {
        $this->murugo([
            new Response(401, [], '{"message":"Unauthenticated."}'),
            new Response(200, [], '{"access_token":"at-2","refresh_token":"rt-2","expires_in":3600}'),
            new Response(200, [], '{"success":true}'),
        ]);
        $user = $this->user();

        $this->assertTrue(MurugoAuthHandler::logout($user));

        $this->assertCount(3, $this->sent);
        $this->assertStringEndsWith('/oauth/token', (string) $this->sent[1]['request']->getUri());
        $this->assertSame('Bearer at-2', $this->sent[2]['request']->getHeaderLine('Authorization'));
        $this->assertTokensCleared($user);
    }

    public function test_refused_logout_returns_false_logs_and_still_clears_tokens()
    {
        $this->murugo([new Response(401, [], '{"message":"Unauthenticated."}')]);
        Log::spy();
        $user = $this->user(null); // no refresh token: nothing to retry with

        $this->assertFalse(MurugoAuthHandler::logout($user));

        $this->assertCount(1, $this->sent);
        $this->assertTokensCleared($user);
        Log::shouldHaveReceived('warning')->once()->withArgs(fn ($message) => str_contains($message, 'SSO logout failed'));
    }

    public function test_unreachable_murugo_returns_false_and_still_clears_tokens()
    {
        $this->murugo([new ConnectException('cURL error 7', new Request('POST', 'https://murugo.test'))]);
        $user = $this->user();

        $this->assertFalse(MurugoAuthHandler::logout($user));
        $this->assertTokensCleared($user);
    }
}
