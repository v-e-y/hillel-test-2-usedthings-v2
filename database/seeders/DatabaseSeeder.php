<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(10)->create();

        $users->each(function ($user) {
            Advertisement::factory(rand(1, 6))
                ->state([
                    'user_id' => $user->id,
                    'is_deleted' => $user->is_deleted
                ])
                ->create();
        });
    }
}
