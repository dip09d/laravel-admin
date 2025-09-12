<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin role
        $superRole = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'admin'
        ]);

     
        $superAdmin = Admin::where('email', 'superadmin@gmail.com')->first();

        // Assign role to Super Admin (permissions will be via role)
        $superAdmin->assignRole($superRole);

        // Menus data
        $menus = [
            ['name' => 'Dashboard', 'slug' => 'dashboard', 'url' => 'admin/dashboard', 'icon_class' => 'fa fa-home', 'parent_id' => 0],
            ['name' => 'Users', 'slug' => 'users', 'url' => 'admin/users', 'icon_class' => 'fa fa-users', 'parent_id' => 0],
            ['name' => 'Permissions', 'slug' => 'permissions', 'url' => 'admin/permissions', 'icon_class' => 'fa fa-lock', 'parent_id' => 0],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::firstOrCreate(['slug' => $menuData['slug']], $menuData);

            // Create permission linked to menu slug
            $permission = Permission::firstOrCreate([
                'name' => $menu->slug,
                'guard_name' => 'admin'
            ]);

            // Assign permission to Super Admin role instead of user
            $superRole->givePermissionTo($permission);
        }
    }
}
