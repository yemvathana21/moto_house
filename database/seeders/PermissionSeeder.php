<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $resources = ['category', 'product', 'customer', 'order', 'review', 'coupon', 'page', 'banner', 'role', 'permission', 'user'];
        $actions = ['view_any', 'view', 'create', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}_{$resource}", 'guard_name' => 'web']);
            }
        }

        Permission::firstOrCreate(['name' => 'view_settings', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'update_settings', 'guard_name' => 'web']);

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->syncPermissions([
            'view_any_category', 'view_category', 'create_category', 'update_category',
            'view_any_product', 'view_product', 'create_product', 'update_product',
            'view_any_customer', 'view_customer', 'create_customer', 'update_customer',
            'view_any_order', 'view_order', 'create_order', 'update_order',
            'view_any_review', 'view_review',
            'view_any_coupon', 'view_coupon',
            'view_any_page', 'view_page', 'create_page', 'update_page',
            'view_any_banner', 'view_banner', 'create_banner', 'update_banner',
            'view_settings', 'update_settings',
        ]);

        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $staff->syncPermissions([
            'view_any_category', 'view_category',
            'view_any_product', 'view_product',
            'view_any_customer', 'view_customer',
            'view_any_order', 'view_order', 'create_order', 'update_order',
            'view_any_review', 'view_review',
        ]);

        $user = \App\Models\User::where('email', 'admin@motohouse.com')->first();
        if ($user) {
            $user->assignRole('super_admin');
        }
    }
}
