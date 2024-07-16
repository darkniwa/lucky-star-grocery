<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define roles
        $customer = Role::create(['name' => 'customer']);
        $admin = Role::create(['name' => 'admin']);
        $owner = Role::create(['name' => 'owner']);
        $manager = Role::create(['name' => 'manager']);
        $cashier = Role::create(['name' => 'cashier']);
        $courier = Role::create(['name' => 'courier']);
        $promodiser = Role::create(['name' => 'promodiser']);

        // Assign permissions to owner
        $admin->givePermissionTo('manage_content');
        $admin->givePermissionTo('manage_staff');

        // Assign permissions to owner
        $owner->givePermissionTo('manage_products');
        $owner->givePermissionTo('process_orders');
        $owner->givePermissionTo('manage_inventory');
        $owner->givePermissionTo('manage_promotions');
        $owner->givePermissionTo('manage_sales_report');
        $owner->givePermissionTo('manage_customer_data');
        $owner->givePermissionTo('manage_billing');
        $owner->givePermissionTo('manage_returns');
        $owner->givePermissionTo('manage_shipping');
        $owner->givePermissionTo('manage_reviews');
        $owner->givePermissionTo('manage_security');
        $owner->givePermissionTo('manage_content');
        $owner->givePermissionTo('manage_staff');
        $owner->givePermissionTo('manage_wallet');

        // Assign permissions to manager
        $manager->givePermissionTo('manage_products');
        $manager->givePermissionTo('process_orders');
        $manager->givePermissionTo('manage_inventory');
        $manager->givePermissionTo('manage_promotions');
        $manager->givePermissionTo('manage_customer_data');
        $manager->givePermissionTo('manage_returns');
        $manager->givePermissionTo('manage_reviews');
        $manager->givePermissionTo('manage_security');
        $manager->givePermissionTo('manage_content');


        // Assign permissions to cashier
        $cashier->givePermissionTo('manage_billing');
        $cashier->givePermissionTo('manage_sales_report');

        // Assign permissions to courier
        $courier->givePermissionTo('manage_shipping');
        $courier->givePermissionTo('manage_wallet');

        // Assign permissions to promodiser
        $promodiser->givePermissionTo('manage_promotions');
        $promodiser->givePermissionTo('manage_content');
    }
}
