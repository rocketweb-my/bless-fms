<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PbmCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berkaitan Borang Permohonan',
                'cat_order' => 1,
                'autoassign' => '1',
                'type' => '0', // Public category
                'priority' => '3', // Medium priority
            ],
            [
                'name' => 'Berkaitan Proses',
                'cat_order' => 2,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
            [
                'name' => 'Berkaitan Profail',
                'cat_order' => 3,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
            [
                'name' => 'Berkaitan status permohonan',
                'cat_order' => 4,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
            [
                'name' => 'Tidak berkaitan/lain-lain',
                'cat_order' => 5,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
        ];

        foreach ($categories as $category) {
            // Check if category already exists
            $exists = DB::table('categories')
                ->where('name', $category['name'])
                ->first();

            if (!$exists) {
                DB::table('categories')->insert($category);
            }
        }

        echo "PBM Categories seeded successfully!\n";
    }
}
