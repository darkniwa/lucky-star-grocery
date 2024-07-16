<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsSeen(User $user, Product $product)
    {
        $notification = Notification::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($notification) {
            $notification->update(['seen' => true]);
        }

        // Redirect or perform other actions as needed
    }
}
