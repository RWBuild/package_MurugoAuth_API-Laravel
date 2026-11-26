<?php

namespace RwandaBuild\MurugoAuth\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use RwandaBuild\MurugoAuth\Facades\MurugoAuth;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use RwandaBuild\MurugoAuth\MurugoAuthHandler;

/** S-03: stateless() skips the state check for one login only, never for later requests */
class StatelessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // the error page links to the package's murugo.auth.redirect route
        $this->app['router']->getRoutes()->refreshNameLookups();
    }

    protected function tearDown(): void
    {
        MurugoAuthHandler::useHttpClient(null);
        parent::tearDown();
    }

    /** Murugo answers one login: token, then /api/thirdparty-me */
    private function murugoAnswersOneLogin(): void
    {
        MurugoAuthHandler::useHttpClient(new Client(['handler' => HandlerStack::create(new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'at', 'refresh_token' => 'rt', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['hashed_murugo_user_id' => 'h-1', 'name' => 'ana', 'avatar' => null, 'public_name' => 'Ana'])),
        ]))]));
    }

    /** A new incoming callback request (as Octane gives each request its own Request object) */
    private function newCallbackRequest(array $query = ['code' => 'c', 'state' => 'from-the-app']): void
    {
        $request = Request::create('/auth/murugo/callback', 'GET', $query);
        $request->setLaravelSession($this->app['session.store']);
        $this->app->instance('request', $request);
    }

    private function assertStateIsChecked(): void
    {
        try {
            MurugoAuth::user();
            $this->fail('the state check was skipped');
        } catch (HttpResponseException $e) {
            $this->assertSame(500, $e->getResponse()->getStatusCode());
        }
    }

    public function test_stateless_login_works_without_a_session_state()
    {
        $this->newCallbackRequest();
        $this->murugoAnswersOneLogin();

        $user = MurugoAuth::stateless()->user();

        $this->assertInstanceOf(MurugoUser::class, $user);
        $this->assertSame('h-1', $user->murugo_user_id);
    }

    public function test_the_next_request_in_the_same_process_checks_the_state_again()
    {
        $this->newCallbackRequest();
        $this->murugoAnswersOneLogin();
        MurugoAuth::stateless()->user();

        $this->newCallbackRequest();   // a later request, no stateless(), no state in the session
        $this->assertStateIsChecked();
    }

    public function test_stateless_called_without_a_login_does_not_carry_over_to_the_next_request()
    {
        $this->newCallbackRequest();
        MurugoAuth::stateless();       // e.g. the request failed before user()

        $this->newCallbackRequest();
        $this->assertStateIsChecked();
    }

    public function test_stateless_applies_to_one_login_only_even_in_the_same_request()
    {
        $this->newCallbackRequest();
        $this->murugoAnswersOneLogin();
        MurugoAuth::stateless()->user();

        $this->assertStateIsChecked();
    }

    public function test_normal_login_still_checks_the_state()
    {
        $this->newCallbackRequest();
        $this->assertStateIsChecked();
    }
}
