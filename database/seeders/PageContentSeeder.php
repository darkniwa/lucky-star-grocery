<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageContent;


class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find the home page
        $homePage = Page::where('name', 'Home')->first();

        if ($homePage) {
            // Create carousel content entries for the home page
            PageContent::create([
                'page_id' => $homePage->id,
                'key' => 'carousel',
                'value' => json_encode([
                    [
                        "image" => "uploads/page_content/{$homePage->id}/slide-01.jpg",
                        "first_line" => "Pomegranate",
                        "second_line" => "Protein Smoothie",
                        "third_line" => "A blend of freshly squeezed green apple & fruits",
                        "buttons" => [
                            [
                                "text" => "Shop now",
                                "link" => "/products"
                            ],
                            [
                                "text" => "View Products",
                                "link" => "/products"
                            ]
                        ]
                    ],
                    [
                        "image" => "uploads/page_content/{$homePage->id}/slide-02.jpg",
                        "first_line" => "Pomegranate",
                        "second_line" => "Fresh Juice",
                        "third_line" => "A blend of freshly squeezed green apple & fruits",
                        "buttons" => [
                            [
                                "text" => "Shop now",
                                "link" => "/products"
                            ],
                            [
                                "text" => "View Products",
                                "link" => "/products"
                            ]
                        ]
                    ],
                    [
                        "image" => "uploads/page_content/{$homePage->id}/slide-03.jpg",
                        "first_line" => "Pomegranate",
                        "second_line" => "Fresh Juice. Nature Drinks",
                        "third_line" => "A blend of freshly squeezed green apple & fruits",
                        "buttons" => [
                            [
                                "text" => "Shop now",
                                "link" => "/products"
                            ],
                            [
                                "text" => "View Products",
                                "link" => "/products"
                            ]
                        ]
                    ]
                ]),
            ]);

            PageContent::create([
                'page_id' => $homePage->id,
                'key' => 'special_offer',
                'value' => json_encode([
                    "image" => "uploads/page_content/{$homePage->id}/special-offer-image.jpg", // Replace with the actual image path
                    "text01" => "Limited",
                    "text02" => "Special Offer",
                    "text03" => "Fruit Basket",
                    "text04" => "Easy Healthy, Happy Life",
                    "product_detail" => [
                        "product_name" => "Special Fruit Basket",
                        "price" => [
                            "currencySymbol" => "Php",
                            "amount" => "250.00"
                        ],
                        "measure" => "per basket",
                        "buttons" => [
                            [
                                "text" => "Add to Cart",
                                "link" => "/products" // Replace with the actual link
                            ]
                        ]
                    ]
                ]),
            ]);
        }
    }
}
