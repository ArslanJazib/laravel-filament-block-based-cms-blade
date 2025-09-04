<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use App\Models\PageBlock;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\CategoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SiteSettingsSeeder::class);

        // Create a test page
        $page = Page::factory()->count(1)->create()->first();

        // Attach blocks in proper order
        PageBlock::factory()->heroBanner()->create([
            'page_id'    => $page->id,
            'sort_order' => 1,
        ]);

        PageBlock::factory()->programSection()->create([
            'page_id'    => $page->id,
            'sort_order' => 2,
        ]);

        PageBlock::factory()->studentSignup()->create([
            'page_id'    => $page->id,
            'sort_order' => 3,
        ]);
    }
}
