<?php

namespace RwandaBuild\MurugoAuth\Tests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RwandaBuild\MurugoAuth\Models\MurugoUser;
use RwandaBuild\MurugoAuth\MurugoUserFormatter;

/** S-13: one murugo_users row per Murugo user; duplicates handled the same way every time */
class MurugoUserFormatterTest extends TestCase
{
    private function rows(string $hashedId): int
    {
        return MurugoUser::where('murugo_user_id', $hashedId)->count();
    }

    public function test_first_login_creates_and_next_login_updates_the_same_row()
    {
        $first = MurugoUserFormatter::get(...$this->bundle('h-1', 'Ana'));
        $second = MurugoUserFormatter::get(...$this->bundle('h-1', 'Ana B'));

        $this->assertSame(1, $this->rows('h-1'));
        $this->assertSame($first->id, $second->id);
        $this->assertSame('Ana B', $second->name);
        $this->assertSame('at-Ana B', $second->token);
    }

    public function test_duplicates_without_a_linked_user_use_the_newest_row_and_log_a_warning()
    {
        DB::table('murugo_users')->insert([
            ['name' => 'old', 'murugo_user_id' => 'h-2', 'token' => 'x'],
            ['name' => 'new', 'murugo_user_id' => 'h-2', 'token' => 'y'],
        ]);
        $newest = MurugoUser::where('murugo_user_id', 'h-2')->max('id');
        Log::spy();

        $user = MurugoUserFormatter::get(...$this->bundle('h-2', 'Bo'));

        $this->assertSame($newest, $user->id);
        $this->assertSame(2, $this->rows('h-2'), 'no row is created or deleted');
        Log::shouldHaveReceived('warning')->once()
            ->withArgs(fn ($message, $context) => str_contains($message, 'duplicate') && $context['used_id'] === $newest);
    }

    public function test_duplicates_always_use_the_row_a_local_user_is_linked_to()
    {
        DB::table('murugo_users')->insert([
            ['name' => 'a', 'murugo_user_id' => 'h-3', 'token' => 'x'],
            ['name' => 'b', 'murugo_user_id' => 'h-3', 'token' => 'y'],
            ['name' => 'c', 'murugo_user_id' => 'h-3', 'token' => 'z'],
        ]);
        $oldest = MurugoUser::where('murugo_user_id', 'h-3')->min('id');
        DB::table('users')->insert(['name' => 'local', 'murugo_user_id' => $oldest]);

        foreach (range(1, 3) as $i) {
            $this->assertSame($oldest, MurugoUserFormatter::get(...$this->bundle('h-3', 'Cy'))->id);
        }
    }

    public function test_the_lock_is_released_after_login()
    {
        MurugoUserFormatter::get(...$this->bundle('h-4'));

        $lock = Cache::lock('murugo-auth:user:' . sha1('h-4'), 10);
        $this->assertTrue($lock->get());
        $lock->release();
    }

    public function test_a_login_waits_for_a_held_lock_then_continues_without_a_duplicate()
    {
        MurugoUserFormatter::get(...$this->bundle('h-5', 'Di'));
        $held = Cache::lock('murugo-auth:user:' . sha1('h-5'), 10);
        $held->get();

        $start = microtime(true);
        $user = MurugoUserFormatter::get(...$this->bundle('h-5', 'Di B'));
        $held->release();

        $this->assertGreaterThanOrEqual(4.5, microtime(true) - $start);
        $this->assertSame(1, $this->rows('h-5'));
        $this->assertSame('Di B', $user->name);
    }

    public function test_global_id_is_kept_as_original_murugo_uuid()
    {
        $user = MurugoUserFormatter::get(...$this->bundle('h-6', 'Eva', 'global-6'));

        $this->assertSame('h-6', $user->murugo_user_id);
        $this->assertSame('global-6', $user->getMurugoUUID());
    }
}
