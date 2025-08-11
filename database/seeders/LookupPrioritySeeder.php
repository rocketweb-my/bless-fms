<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'priority_value' => 1,
                'name_en' => 'High',
                'name_ms' => 'Tinggi',
                'duration_days' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority_value' => 2,
                'name_en' => 'Medium',
                'name_ms' => 'Sederhana',
                'duration_days' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'priority_value' => 3,
                'name_en' => 'Low',
                'name_ms' => 'Rendah',
                'duration_days' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('lookup_priority')->insert($priorities);
    }
}
