<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('records')->insert([
            'action_id' => 1,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 29, 8, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 29, 14)->format('Y-m-d H:i:s'),
        ]);
        DB::table('records')->insert([
            'action_id' => 2,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 29, 10, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 29, 10, 34)->format('Y-m-d H:i:s'),
        ]);
        DB::table('records')->insert([
            'action_id' => 1,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 30, 8, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 30, 15)->format('Y-m-d H:i:s'),
        ]);
        DB::table('records')->insert([
            'action_id' => 2,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 31, 23, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 31, 23, 34)->format('Y-m-d H:i:s'),
        ]);
        DB::table('records')->insert([
            'action_id' => 1,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 31, 18, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 31, 22)->format('Y-m-d H:i:s'),
        ]);
        DB::table('records')->insert([
            'action_id' => 2,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 31, 23, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 31, 23, 34)->format('Y-m-d H:i:s'),
        ]);

        DB::table('records')->insert([
            'action_id' => 2,
            'user_id' => '40559258',
            'finished' => true,
            'created_at' => Carbon::create(2017, 1, 31, 23, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 31, 23, 34)->format('Y-m-d H:i:s'),
        ]);


        DB::table('records')->insert([
            'action_id' => 1,
            'user_id' => '40559258',
            'finished' => false,
            'created_at' => Carbon::create(2017, 1, 31, 18, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 31, 22)->format('Y-m-d H:i:s'),
        ]);
        DB::table('records')->insert([
            'action_id' => 2,
            'user_id' => '40559258',
            'finished' => false,
            'created_at' => Carbon::create(2017, 1, 31, 23, 1)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::create(2017, 1, 31, 23, 34)->format('Y-m-d H:i:s'),
        ]);

    }
}
