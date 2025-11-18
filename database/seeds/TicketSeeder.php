<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<= 50; $i++)
        {
            DB::table('tickets')->insert([
                'viber_number' => '09'. rand(100000000, 999999999),
                'department_id' => DB::table('departments')->inRandomOrder()->value('id'),
                'subject' => Str::random(20),
                'task' => Str::random(20),
                'status' => 'Open',
                'created_by' => DB::table('users')->inRandomOrder()->value('id'),
                'priority' => Arr::random(['High', 'Medium', 'Low']),
                'category_id' => DB::table('categories')->inRandomOrder()->value('id')
            ]);
        }
    }
}
