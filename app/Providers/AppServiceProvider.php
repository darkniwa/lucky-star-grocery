<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        try {
            $categories = DB::table('products')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->select('products.category_id', 'categories.id', 'categories.name')
                ->groupBy('categories.id', 'categories.name', 'products.category_id')
                ->get();

            $allCategories = Category::all();
            $data = [
                'categories' => $categories,
                'allCategories' => $allCategories
            ];

            View::share($data);
        } catch (\Throwable $th) {
            //throw $th;
        }

        Blade::directive('currency', function ($money, $withSymbol = true) {
            return "<?php echo number_format($money, 2); ?>";
        });

        Blade::directive('datetime', function (string $expression) {
            return "<?php echo date_format($expression,'F j - h:i A') ?>";
        });

        View::composer('inc.seller.sidebar', function ($view) {
            // Retrieve the unseen notifications count for the authenticated user
            $user = auth()->user()->load('unreadNotifications');
            $unseenNotificationsCount = $user->unreadNotifications->count();
            // Share the variable with the view
            $view->with('unseenNotificationsCount', $unseenNotificationsCount);
        });
    }
}
