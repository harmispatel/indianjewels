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
            'admin.categories',
            'categories.add-category',
            'categories.edit-category',
            'categories.destroy',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
