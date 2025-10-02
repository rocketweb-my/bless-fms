<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pertanyaan Umum',
                'cat_order' => 1,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
            [
                'name' => 'Aduan Aplikasi',
                'cat_order' => 2,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
            [
                'name' => 'Aduan Server',
                'cat_order' => 3,
                'autoassign' => '1',
                'type' => '0',
                'priority' => '3',
            ],
        ];

        foreach ($categories as $category) {
            // Check if category already exists
            $exists = Category::where('name', $category['name'])->first();

            if (!$exists) {
                Category::create($category);
            }
        }

        echo "Categories seeded successfully!\n";
    }
}
