<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            // Dashboard
            'categories.count',
            'tags.count',
            'designs.count',
            'pages.count',
            'orders.count',
            'users.count',
            'dealers.count',
            'customers.count',
            'pending.orders.list',

            // Categories
            'categories.index',
            'categories.create',
            'categories.edit',
            'categories.destroy',
            'categories.status',

            // Tags
            'tags.index',
            'tags.create',
            'tags.edit',
            'tags.status',
            'tags.destroy',
            'tags.header.status',

            // Designs
            'designs.index',
            'designs.create',
            'designs.edit',
            'designs.destroy',
            'designs.status',
            'designs.top-selling.status',

            // Dealers
            'dealers.index',
            'dealers.create',
            'dealers.edit',
            'dealers.destroy',
            'dealers.status',

            // Users
            'users.index',
            'users.create',
            'users.edit',
            'users.destroy',
            'users.status',

            // Roles
            'roles.index',
            'roles.create',
            'roles.edit',
            'roles.destroy',

            // Customers
            'customers.index',
            'customers.edit',
            'customers.status',

            // Orders
            'orders.index',
            'orders.show',
            'orders.accept',
            'orders.process',
            'orders.complete',

            // Top Banners
            'top-banners.index',
            'top-banners.create',
            'top-banners.edit',
            'top-banners.destroy',
            'top-banners.status',

            // Middle Banners
            'middle-banners.index',
            'middle-banners.create',
            'middle-banners.edit',
            'middle-banners.destroy',
            'middle-banners.status',

            // Bottom Banners
            'bottom-banners.index',
            'bottom-banners.create',
            'bottom-banners.edit',
            'bottom-banners.destroy',
            'bottom-banners.status',

            // Pages
            'pages.index',
            'pages.create',
            'pages.edit',
            'pages.destroy',
            'pages.status',

            // Report

            // Other
            'settings.index',
            'settings.update',
            'myprofile.index',
            'myprofile.update',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
