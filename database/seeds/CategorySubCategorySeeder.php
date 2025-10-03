<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;

class CategorySubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        SubCategory::truncate();
        Category::truncate();

        // Category 1: Pertanyaan Umum (no sub-categories needed based on form)
        $pertanyaanUmum = Category::create([
            'name' => 'Pertanyaan Umum',
        ]);

        // Category 2: Aduan Aplikasi
        $aduanAplikasi = Category::create([
            'name' => 'Aduan Aplikasi',
        ]);

        // Sub-categories for Aduan Aplikasi
        SubCategory::create([
            'category_id' => $aduanAplikasi->id,
            'name' => 'Lesen',
        ]);

        SubCategory::create([
            'category_id' => $aduanAplikasi->id,
            'name' => 'Main App',
        ]);

        SubCategory::create([
            'category_id' => $aduanAplikasi->id,
            'name' => 'Lain-lain',
        ]);

        // Category 3: Aduan Server
        $aduanServer = Category::create([
            'name' => 'Aduan Server',
        ]);

        // Sub-categories for Aduan Server
        SubCategory::create([
            'category_id' => $aduanServer->id,
            'name' => 'Portal BLESS',
        ]);

        SubCategory::create([
            'category_id' => $aduanServer->id,
            'name' => 'BLESS Generasi Baharu',
        ]);

        SubCategory::create([
            'category_id' => $aduanServer->id,
            'name' => 'BLESS 1.0',
        ]);

        SubCategory::create([
            'category_id' => $aduanServer->id,
            'name' => 'Aplikasi Mudah Alih',
        ]);

        $this->command->info('Categories and Sub-categories seeded successfully!');
    }
}
