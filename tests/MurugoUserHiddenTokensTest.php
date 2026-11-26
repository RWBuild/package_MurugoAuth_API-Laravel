<?php

namespace RwandaBuild\MurugoAuth\Tests;

use RwandaBuild\MurugoAuth\Models\MurugoUser;

/** S-08: Murugo tokens are not serialised with the model */
class MurugoUserHiddenTokensTest extends TestCase
{
    private function murugoUser(): MurugoUser
    {
        return MurugoUser::create([
            'name' => 'ana', 'murugo_user_id' => 'h-1', 'murugo_user_public_name' => 'Ana',
            'token' => 'secret-access-token', 'refresh_token' => 'secret-refresh-token', 'token_expires_at' => now()->addHour(),
        ]);
    }

    public function test_tokens_are_not_in_array_or_json()
    {
        $user = $this->murugoUser()->fresh();

        $this->assertArrayNotHasKey('token', $user->toArray());
        $this->assertArrayNotHasKey('refresh_token', $user->toArray());
        $this->assertStringNotContainsString('secret-', $user->toJson());
        $this->assertSame('Ana', $user->toArray()['murugo_user_public_name'], 'the other fields are still there');
    }

    public function test_tokens_are_not_in_json_when_loaded_through_a_relation_or_collection()
    {
        $this->murugoUser();

        $this->assertStringNotContainsString('secret-', MurugoUser::all()->toJson());
        $this->assertStringNotContainsString('secret-', json_encode(['murugo_user' => MurugoUser::first()]));
    }

    public function test_server_code_still_reads_the_tokens()
    {
        $user = $this->murugoUser()->fresh();

        $this->assertSame('secret-access-token', $user->token);
        $this->assertSame('secret-refresh-token', $user->refresh_token);
        $this->assertSame('secret-access-token', $user->makeVisible('token')->toArray()['token']);
    }
}
