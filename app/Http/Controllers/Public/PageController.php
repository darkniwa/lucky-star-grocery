<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\Product;
use App\Models\Category;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        try {
            // Retrieve data for carousel
            $carouselData = $this->getCarouselData();

            // Retrieve data for special offer
            $specialOffer = $this->getSpecialOffer();

            // Retrieve best selling products
            $bestSellerProducts = $this->getBestSellerProducts();

            $data = [
                'best_seller' => $bestSellerProducts,
                'special_offer' => $specialOffer['product'],
                'carouselData' => $carouselData,
                'specialOfferData' => $specialOffer['data']
            ];

            return view('pages.customer.index')->with($data);
        } catch (\Throwable $th) {
            // Handle the exception if needed
        }
    }

    public function products(Request $request)
    {
        $searchTerm = $request->input('product-search');
        $category = $request->category;
        $priceRange = $request->price; // Get the selected price range from the form
        $selectedPrice = $request->input('price');
        // If no price range is selected, use a default value (e.g., 'all')
        if (!$selectedPrice) {
            $selectedPrice = 'all';
        }

        // Sorting logic
        $selectedSorting = $request->input('orderby', 'price-desc'); // Default sorting by price descending
        $sortByPrice = $selectedSorting === 'price' ? 'asc' : 'desc';

        $query = Product::where('availability', '>', 0)
            ->orderBy('price', $sortByPrice)
            ->orderBy('id', 'desc');

        if ($selectedSorting === 'default') {
            $query->orderBy('id', 'desc');
        }

        if ($category) {
            $query->where('category_id', $category);
        } elseif ($searchTerm) {
            $searchTerm = str_replace(' ', '%', $searchTerm);
            $query->where('product_name', 'like', "%$searchTerm%");
        }

        // Add price filtering based on the selected price range
        if ($priceRange) {
            switch ($priceRange) {
                case '1':
                    $query->where('price', '<', 50);
                    break;
                case '2':
                    $query->whereBetween('price', [50, 100]);
                    break;
                case '3':
                    $query->whereBetween('price', [100, 200]);
                    break;
                case '4':
                    $query->whereBetween('price', [200, 500]);
                    break;
                case '5':
                    $query->where('price', '>', 500);
                    break;
            }
        }

        $products = $query->paginate(12);

        return view('pages.customer.products', compact('products', 'selectedPrice', 'selectedSorting'));
    }


    public function contact()
    {
        return view('pages.customer.contact');
    }

    public function product($id)
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)->get();
        $productCategory = Category::findOrFail($product->category_id);

        $data = [
            'product' => $product,
            'related_products' => $relatedProducts,
            'product_category' => $productCategory,
        ];

        return view('pages.customer.product', $data);
    }


    private function getCarouselData()
    {
        $homePage = Page::where('name', 'Home')->first();
        $carouselData = [];

        if ($homePage) {
            $carouselContent = $homePage->content->where('key', 'carousel')->first();

            if ($carouselContent) {
                $carouselData = json_decode($carouselContent->value, true);
            }
        }

        return $carouselData;
    }

    private function getBestSellerProducts()
    {
        return Product::orderBy('id', 'desc')->offset(0)->limit(10)->get();
    }

    private function getSpecialOffer()
    {
        $specialOfferContent = PageContent::where('key', 'special_offer')->first();
        $specialOfferData = json_decode($specialOfferContent->value);

        $specialOfferProduct = Product::whereNotNull('discounted_price')->offset(0)->limit(1)->get();

        return [
            'data' => $specialOfferData,
            'product' => $specialOfferProduct->first()
        ];
    }
}
