<?php

namespace RwandaBuild\MurugoAuth\Tests;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use RwandaBuild\MurugoAuth\MurugoUserFormatter;

/** F-9: new Murugo tokens are encrypted in the database; old plain-text rows keep working */
class EncryptedTokensTest extends TestCase
{
    private function raw(int $id): object
    {
        return DB::table('murugo_users')->where('id', $id)->first();
    }

    private function oldPlainTextRow(): MurugoUser
    {
        $id = DB::table('murugo_users')->insertGetId([
            'name' => 'old', 'murugo_user_id' => 'h-old', 'token' => 'old-plain-access', 'refresh_token' => 'old-plain-refresh',
        ]);

        return MurugoUser::find($id);
    }

    public function test_new_tokens_are_encrypted_in_the_database_and_read_back()
    {
        [$user, $tokens] = $this->bundle('h-1');
        $murugoUser = MurugoUserFormatter::get($user, $tokens);

        $row = $this->raw($murugoUser->id);
        $this->assertStringStartsWith('enc:', $row->token);
        $this->assertStringStartsWith('enc:', $row->refresh_token);
        $this->assertStringNotContainsString('at-Ana', $row->token);

        $fresh = MurugoUser::find($murugoUser->id);
        $this->assertSame('at-Ana', $fresh->token);
        $this->assertSame('rt-Ana', $fresh->refresh_token);
    }

    public function test_old_plain_text_rows_still_work()
    {
        $old = $this->oldPlainTextRow();

        $this->assertSame('old-plain-access', $old->token);
        $this->assertSame('old-plain-refresh', $old->refresh_token);
    }

    public function test_old_row_is_encrypted_when_its_tokens_are_next_saved()
    {
        $old = $this->oldPlainTextRow();

        $updated = MurugoUserFormatter::updateAccessToken($old, ['access_token' => 'new-access', 'refresh_token' => 'new-refresh', 'expires_in' => 3600]);

        $this->assertStringStartsWith('enc:', $this->raw($old->id)->token);
        $this->assertSame('new-access', $updated->token);
        $this->assertSame('new-refresh', $updated->refresh_token);
    }

    public function test_saving_a_model_that_was_read_does_not_encrypt_twice()
    {
        [$user, $tokens] = $this->bundle('h-2');
        $murugoUser = MurugoUser::find(MurugoUserFormatter::get($user, $tokens)->id);

        $murugoUser->name = 'renamed';
        $murugoUser->save();

        $this->assertSame('at-Ana', MurugoUser::find($murugoUser->id)->token);
    }

    public function test_cleared_tokens_stay_empty()
    {
        $murugoUser = MurugoUser::create(['name' => 'a', 'murugo_user_id' => 'h-3', 'token' => 'x', 'refresh_token' => 'y']);
        $murugoUser->forceFill(['token' => '', 'refresh_token' => null])->save();

        $row = $this->raw($murugoUser->id);
        $this->assertSame('', $row->token);
        $this->assertNull($row->refresh_token);
    }

    public function test_token_that_cannot_be_decrypted_reads_as_null()
    {
        $other = new Encrypter(random_bytes(32), 'AES-256-CBC');
        $id = DB::table('murugo_users')->insertGetId([
            'name' => 'k', 'murugo_user_id' => 'h-4', 'token' => 'enc:' . $other->encryptString('secret'), 'refresh_token' => null,
        ]);

        $this->assertNull(MurugoUser::find($id)->token);
    }

    public function test_encryption_can_be_turned_off_for_new_tokens()
    {
        config(['services.murugo.encrypt_tokens' => false]);
        $encryptedBefore = 'enc:' . Crypt::encryptString('stored-encrypted');
        $id = DB::table('murugo_users')->insertGetId(['name' => 'p', 'murugo_user_id' => 'h-5', 'token' => $encryptedBefore]);

        $murugoUser = MurugoUser::create(['name' => 'q', 'murugo_user_id' => 'h-6', 'token' => 'plain-new']);

        $this->assertSame('plain-new', $this->raw($murugoUser->id)->token);
        $this->assertSame('stored-encrypted', MurugoUser::find($id)->token, 'already encrypted tokens still read');
    }

    public function test_tokens_stay_hidden_from_json()
    {
        $murugoUser = MurugoUser::create(['name' => 'j', 'murugo_user_id' => 'h-7', 'token' => 'secret-access']);

        $this->assertArrayNotHasKey('token', $murugoUser->fresh()->toArray());
    }
}
