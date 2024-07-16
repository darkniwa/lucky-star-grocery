<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ProductsExport
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    // Function to add quotes around each value
    private function add_quotes($value)
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }

    public function export()
    {
        $exportDate = Carbon::now()->format('Ymd_His');

        $csvData = collect([
            ['Product ID', 'Category', 'Product Name', 'Variation', 'Available Stocks', 'Price', 'Units Sold']
        ]);

        foreach ($this->products as $product) {
            $csvData->push([
                $product->id,
                $product->getCategoryRelation->name,
                $product->product_name,
                $product->variation,
                $product->availability,
                $product->price,
                $product->getUnitsSoldAttribute(),
            ]);
        }

        $csvContent = $csvData->map(function ($row) {
            return implode(',', array_map([$this, 'add_quotes'], $row));
        })->implode("\n");

        $filename = 'lucky_star_products_' . $exportDate . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
