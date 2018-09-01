<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 521,
            'name' => 'user1',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('users')->insert([
            'id' => 522,
            'name' => 'user2',
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        DB::table('messages')->insert([
            'from_id' => 521,
            'to_id' => 522,
            'content' => str_random(15),
        ]);

        DB::table('messages')->insert([
            'from_id' => 522,
            'to_id' => 521,
            'content' => str_random(15),
        ]);
    }
}
