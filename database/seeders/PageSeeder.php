<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if the home page already exists
        $homePage = Page::where('name', 'Home')->first();

        if (!$homePage) {
            // Create the home page
            Page::create([
                'name' => 'Home',
            ]);
        }

        // Check if the contact page already exists
        $contactPage = Page::where('name', 'Contact')->first();

        if (!$contactPage) {
            // Create the contact page
            Page::create([
                'name' => 'Contact',
            ]);
        }
    }
}
