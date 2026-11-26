<?php

namespace RwandaBuild\MurugoAuth\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthException;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use RwandaBuild\MurugoAuth\MurugoAuthHandler;

/** S-11: timeouts on calls to Murugo, one way of joining Murugo URLs, clear error when MURUGO_URL is not set */
class HttpConfigTest extends TestCase
{
    private array $sent = [];

    protected function tearDown(): void
    {
        MurugoAuthHandler::useHttpClient(null);
        parent::tearDown();
    }

    private function setMurugoUrl(?string $url): void
    {
        config(['services.murugo.murugo_url' => $url]);
    }

    public function test_default_client_has_timeouts()
    {
        $client = MurugoAuthHandler::init()->httpClient;

        $this->assertSame(5.0, $client->getConfig('connect_timeout'));
        $this->assertSame(15.0, $client->getConfig('timeout'));
    }

    public function test_timeouts_can_be_configured()
    {
        config(['services.murugo.connect_timeout' => 2, 'services.murugo.timeout' => 30]);
        $client = MurugoAuthHandler::init()->httpClient;

        $this->assertSame(2.0, $client->getConfig('connect_timeout'));
        $this->assertSame(30.0, $client->getConfig('timeout'));
    }

    public function test_urls_are_joined_with_one_slash()
    {
        foreach (['https://murugo.test', 'https://murugo.test/', ' https://murugo.test// '] as $base) {
            $this->setMurugoUrl($base);
            $auth = MurugoAuthHandler::init();

            $this->assertSame('https://murugo.test/oauth/token', $auth->murugoUrl('/oauth/token'));
            $this->assertSame('https://murugo.test/oauth/token', $auth->murugoUrl('oauth/token'));
        }
    }

    public function test_redirect_goes_to_one_slash_authorize_url()
    {
        $this->setMurugoUrl('https://murugo.test/');
        config(['services.murugo.disable_user_session' => false]);
        $this->app['request']->setLaravelSession($this->app['session.store']);

        $target = MurugoAuthHandler::redirect()->getTargetUrl();

        $this->assertStringStartsWith('https://murugo.test/oauth/authorize?', $target);
    }

    public function test_missing_or_placeholder_murugo_url_fails_clearly()
    {
        foreach ([null, '', 'MURUGO_URL', '/relative', 'ftp://murugo.test'] as $bad) {
            $this->setMurugoUrl($bad);

            try {
                MurugoAuthHandler::init()->murugoUrl('/oauth/token');
                $this->fail('No exception for ' . var_export($bad, true));
            } catch (MurugoAuthException $e) {
                $this->assertSame(500, $e->render()->getStatusCode());
                $this->assertStringNotContainsString('MURUGO_URL', $e->getMessage(), 'no config details shown to users');
            }
        }
    }

    public function test_refresh_token_request_sends_accept_and_app_key_like_the_other_calls()
    {
        $stack = HandlerStack::create(new MockHandler([new Response(200, [], '{"access_token":"at-2","refresh_token":"rt-2","expires_in":3600}')]));
        $stack->push(Middleware::history($this->sent));
        MurugoAuthHandler::useHttpClient(new Client(['handler' => $stack]));
        $this->setMurugoUrl('https://murugo.test/');

        $user = MurugoUser::create(['name' => 'ana', 'murugo_user_id' => 'h-1', 'token' => 'at-1', 'refresh_token' => 'rt-1']);
        MurugoAuthHandler::refreshToken($user);

        $request = $this->sent[0]['request'];
        $this->assertSame('https://murugo.test/oauth/token', (string) $request->getUri());
        $this->assertSame('application/json', $request->getHeaderLine('accept'));
        $this->assertSame('app-key', $request->getHeaderLine('APPKEY'));
    }
}
