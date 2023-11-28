<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            ['event_type' => 'Meeting with an expert'],
            ['event_type' => 'Question-answer'],
            ['event_type' => 'Conference'],
            ['event_type' => 'Webinar'],
        ];

        DB::table('event_types')->insert($eventTypes);
    }
}
