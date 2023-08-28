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
            'roles',
            'roles.create',
            'roles.edit',
            'roles.destroy',
            'tags',
            'tags.create',
            'tags.edit',
            'tags.destroy',
            'designs',
            'designs.create',
            'designs.edit',
            'designs.destroy',
            'categories',
            'categories.add',
            'categories.edit',
            'categories.destroy',
            'users',
            'users.create',
            'users.edit',
            'users.destroy',
            'sliders',
            'sliders.add-slider',
            'sliders.edit-slider',
            'sliders.destroy',
            'dealers',
            'dealers.create',
            'dealers.edit',
            'dealers.destroy',
            'westage.discount',
            'westage.discount.create',
            'westage.discount.edit',
            'westage.discount.destroy',
            'reports.summary.items',
            'reports.star',
            'reports.scheme',
            'reports.dealer.performace',
            'order',
            'marketing',
            'import.export',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
