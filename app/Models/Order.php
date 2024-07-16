<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    // Status ['Order Confirmed', 'To Pack', 'Ready To Ship', 'Shipping', 'Ready for Pick Up', 'Delivered', 'Cancelled', 'Return', 'Failed Delivery']
    protected $fillable = ['user_id', 'product_id', 'quantity', 'status', 'delivery_address_id'];

    public function getProductRelation()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getCustomerRelation()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }

    public function getUserRelation()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getPaymentRelation()
    {
        return $this->hasOne(Payment::class, 'order_number', 'order_number');
    }

    public function getDeliveryRelation()
    {
        return $this->hasOne(Delivery::class, 'order_number', 'order_number');
    }

    public function deliveryAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_addresses_id');
    }

    public function getTotalCostAttribute()
    {
        return $this->getPaymentRelation->total_cost + $this->getPaymentRelation->shipping_fee;
    }

    public function getOrderDetails()
    {
        return Order::where('order_number', $this->order_number)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'products.product_name',
                'products.variation',
                'products.price',
                'orders.quantity'
            )
            ->get()
            ->toJson();
    }

    public function remittance()
    {
        return $this->hasOne(Remittance::class, 'order_number', 'order_number');
    }
}
