<?php

namespace App\Exports;

use App\Order;
use Illuminate\Support\Collection;

class SalesExport
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    // Function to add quotes around each value
    private function add_quotes($value)
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }

    private function formatDeliveryAddress($jsonAddress)
    {
        // Decode the JSON string
        $addressData = json_decode($jsonAddress, true);

        if ($addressData) {
            // Format the address components
            $formattedAddress = sprintf(
                "%s, %s, %s, %s %s",
                $addressData['street'],
                $addressData['barangay'],
                $addressData['city'],
                $addressData['province'],
                $addressData['postal_code']
            );

            return $formattedAddress;
        }

        return "Invalid Address"; // Handle the case where JSON decoding fails
    }

    public function export()
    {
        $startDate = $this->sales->first()->created_at->format('M j, Y');
        $endDate = $this->sales->last()->created_at->format('M j, Y');
    
        if ($startDate === $endDate) {
            $dateRange = $startDate;
        } else {
            $dateRange = $startDate . '_to_' . $endDate;
        }
    
        $csvData = collect([
            ['Order Number', 'Order Date', 'Customer Name', 'Product Name', 'Quantity', 'Unit Price', 'Total Price', 'Payment Method', 'Shipping Address']
        ]);
    
        foreach ($this->sales as $sale) {
            $orderDate = $sale->created_at->format('Y-m-d H:i:s');  // Adjust the date format
            $totalPrice = $sale->quantity * $sale->getProductRelation->price;
    
            // Map payment method
            $paymentMethod = ($sale->mode_of_payment == 'cod') ? "Cash on Delivery" : (($sale->mode_of_payment == "gcash") ? "GCash" : '');
    
            // Map shipping address
            $shippingAddress = ($sale->user_addresses_id == null)
                ? "Pick-up on store location"
                : $this->formatDeliveryAddress($sale->deliveryAddress);
    
            $csvData->push([
                $sale->order_number,
                $orderDate,
                $sale->getUserRelation->display_name,
                $sale->getProductRelation->product_name,
                $sale->getProductRelation->variation,
                $sale->quantity,
                $sale->getProductRelation->price,
                $totalPrice,
                $paymentMethod,
                $shippingAddress,
            ]);
        }
    
        $csvContent = $csvData->map(function ($row) {
            return implode(',', array_map([$this, 'add_quotes'], $row));
        })->implode("\n");
    
        $filename = 'sales_export_' . $dateRange . '.csv';
    
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    
}
