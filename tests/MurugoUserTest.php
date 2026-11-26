<?php

namespace RwandaBuild\MurugoAuth\Tests;

use RwandaBuild\MurugoAuth\Models\MurugoUser;

/** S-09: original_murugo_uuid is not a column; it must be readable and must not break save() */
class MurugoUserTest extends TestCase
{
    public function test_original_murugo_uuid_can_be_read_and_is_in_json()
    {
        $user = MurugoUser::create(['name' => 'a', 'murugo_user_id' => 'h-1', 'token' => 't']);
        $user->original_murugo_uuid = 'uuid-42';

        $this->assertSame('uuid-42', $user->getMurugoUUID());
        $this->assertSame('uuid-42', json_decode($user->toJson(), true)['original_murugo_uuid']);
    }

    public function test_save_still_works_after_setting_it()
    {
        $user = MurugoUser::create(['name' => 'a', 'murugo_user_id' => 'h-1', 'token' => 't']);
        $user->original_murugo_uuid = 'uuid-42';
        $user->name = 'b';
        $user->save();

        $this->assertSame('b', $user->fresh()->name);
    }
}
