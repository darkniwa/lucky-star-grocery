<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Define permissions
         Permission::create(['name' => 'manage_products']);
         Permission::create(['name' => 'process_orders']);
         Permission::create(['name' => 'manage_inventory']);
         Permission::create(['name' => 'manage_promotions']);
         Permission::create(['name' => 'manage_sales_report']);
         Permission::create(['name' => 'manage_customer_data']);
         Permission::create(['name' => 'manage_billing']);
         Permission::create(['name' => 'manage_returns']);
         Permission::create(['name' => 'manage_shipping']);
         Permission::create(['name' => 'manage_reviews']);
         Permission::create(['name' => 'manage_security']);
         Permission::create(['name' => 'manage_content']);
         Permission::create(['name' => 'manage_staff']);
         Permission::create(['name' => 'manage_wallet']);
    }
}
