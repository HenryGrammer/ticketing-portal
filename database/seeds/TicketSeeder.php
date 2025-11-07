<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->insert([
            'viber_number' => Str::random(10),
            'department_id' => Str::random(10).'@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
