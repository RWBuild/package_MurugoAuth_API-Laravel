<?php

namespace RwandaBuild\MurugoAuth\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthDenied;
use RwandaBuild\MurugoAuth\Exceptions\MurugoAuthException;
use RwandaBuild\MurugoAuth\Exceptions\MurugoInvalidSateRequest;
use RwandaBuild\MurugoAuth\MurugoAuthHandler;

/** S-12: Murugo's error details go to the log, never to the user */
class ErrorMessagesTest extends TestCase
{
    private function fire(string $method, \Throwable $error): MurugoAuthException
    {
        $m = new \ReflectionMethod(MurugoAuthHandler::class, $method);
        $m->setAccessible(true);

        try {
            $m->invoke(null, $error);
        } catch (MurugoAuthException $e) {
            return $e;
        }

        $this->fail('No MurugoAuthException thrown');
    }

    private function clientError(int $status): ClientException
    {
        $body = '{"message":"Application not found","file":"/var/www/murugo/app/Listeners/CreateMurugoHashedId.php"}';

        return new ClientException(
            "Client error: `POST https://murugo.test/oauth/token` resulted in a `$status` response: $body",
            new Request('POST', 'https://murugo.test/oauth/token'),
            new Response($status, [], $body)
        );
    }

    public function test_murugo_401_shows_a_generic_message_and_keeps_details_for_the_log()
    {
        $e = $this->fire('fireError', $this->clientError(401));
        $response = $e->render();

        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame(['success' => false, 'message' => 'Murugo login failed. Please sign in again.'], $response->getData(true));
        $this->assertStringNotContainsString('murugo.test', $response->getContent());
        $this->assertStringNotContainsString('/var/www', $response->getContent());
        $this->assertStringContainsString('/var/www', $e->context()['murugo_error']);
        $this->assertSame(401, $e->context()['murugo_status']);
    }

    public function test_other_murugo_errors_keep_their_status_with_a_generic_message()
    {
        $response = $this->fire('fireError', $this->clientError(422))->render();

        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame('Murugo login could not be completed. Please try again.', $response->getData(true)['message']);
    }

    public function test_unreachable_murugo_is_503_without_curl_details()
    {
        $e = $this->fire('fireConnectError', new ConnectException(
            'cURL error 7: Failed to connect to murugo.internal port 8090',
            new Request('GET', 'https://murugo.internal:8090/api/thirdparty-me')
        ));
        $response = $e->render();

        $this->assertSame(503, $response->getStatusCode());
        $this->assertStringNotContainsString('cURL', $response->getContent());
        $this->assertStringContainsString('cURL error 7', $e->context()['murugo_error']);
    }

    public function test_denied_and_invalid_state_still_render_403()
    {
        $this->assertSame(403, (new MurugoAuthDenied('Denied'))->render()->getStatusCode());
        $this->assertSame(403, (new MurugoInvalidSateRequest('Bad state'))->render()->getStatusCode());
    }
}
