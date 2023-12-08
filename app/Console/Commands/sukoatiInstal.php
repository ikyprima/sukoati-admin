<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuHasRole;
class sukoatiInstal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sukoati:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install Sukoati-Admin meliputi generate role, permission, menu dan user admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permission = Permission::firstOrCreate(
            [
                'name'=> 'admin.index'
            ]
        );

        $role =  Role::firstOrCreate(
                [
                    'name'=> 'admin'
                ]
        );

        $role->givePermissionTo($permission->name);
        
        $user = User::updateOrCreate([
            'username' => 'sukoatiadmin',
    
            ], [
            'email' => 'sukoatiadmin@mail.com',
            'name' =>  'administrator',
            'password' => bcrypt('password')
        
        ]);
        
        $user->assignRole(['admin']);

        //membuat kategori menu setting
        $menu =  Menu::firstOrCreate(
            [
                'name'=> 'setting',
                'order' =>1
            ]
        );

        //membuat item menu
        $menuItem =  MenuItem::firstOrCreate(
            [
                'is_parent'=> 1,
                'id_menu' =>$menu->id,
                'title' => 'Menu',
                'url'=>url('/').'/admin/menu', //lihat di route (web)
                'name_route'=>'menu.index' //lihat di name route (web)
            ]
        );

        //menambahkan role admin ke setting menu
        MenuHasRole::firstOrCreate(
            [
                'id_menu' => $menuItem->id, //id menu item
                'id_roles' => $role->id,
                'ket' => 'role admin memiliki setting->menu'
            ]
        );

          //membuat item menu user
        $menuUser =  MenuItem::firstOrCreate(
            [
                'is_parent'=> 1,
                'id_menu' =>$menu->id,
                'title' => 'User',
                'url'=>url('/').'/admin/user', //lihat di route (web)
                'name_route'=>'user.index' //lihat di name route (web)
            ]
        );

        //menambahkan role admin ke setting user
        MenuHasRole::firstOrCreate(
            [
                'id_menu' => $menuUser->id, //id menu item
                'id_roles' => $role->id,
                'ket' => 'role admin memiliki menu setting->user'
            ]
        );

           //membuat item menu Role
        $menuRole =  MenuItem::firstOrCreate(
            [
                'is_parent'=> 1,
                'id_menu' =>$menu->id,
                'title' => 'Role',
                'url'=>url('/').'/admin/role', //lihat di route (web)
                'name_route'=>'role.index' //lihat di name route (web)
            ]
        );

        //menambahkan admin ke setting role
        MenuHasRole::firstOrCreate(
            [
                'id_menu' => $menuRole->id, //id menu item
                'id_roles' => $role->id,
                'ket' => 'role admin memiliki menu setting->role'
            ]
        );

         //membuat item menu Permission
        $menuPermissions =  MenuItem::firstOrCreate(
            [
                'is_parent'=> 1,
                'id_menu' =>$menu->id,
                'title' => 'Permissions',
                'url'=>url('/').'/admin/permissions', //lihat di route (web)
                'name_route'=>'permissions.index' //lihat di name route (web)
            ]
        );

        //menambahkan admin ke setting role
        MenuHasRole::firstOrCreate(
            [
                'id_menu' => $menuPermissions->id, //id menu item
                'id_roles' => $role->id,
                'ket' => 'role admin memiliki menu setting->permissions'
            ]
        );

        //buat menu kategori tools
        $tools =  Menu::firstOrCreate(
            [
                'name'=> 'tools',
                'order' =>2
            ]
        );

        //membuat item menu database
        $menuDatabase =  MenuItem::firstOrCreate(
            [
                'is_parent'=> 1,
                'id_menu' =>$tools->id,
                'title' => 'Database',
                'url'=>url('/').'/admin/database', //lihat di route (web)
                'name_route'=>'database.index' //lihat di name route (web)
            ]
        );

        //menambahkan role admin ke setting menu
        MenuHasRole::firstOrCreate(
            [
                'id_menu' => $menuDatabase->id, 
                'id_roles' => $role->id,
                'ket' => 'role admin memiliki menu tools database'
            ]
        );

        //membuat item menu builder
        $menuBuilder =  MenuItem::firstOrCreate(
            [
                'is_parent'=> 1,
                'id_menu' =>$tools->id,
                'title' => 'Form Builder',
                'url'=>url('/').'/admin/builder', 
                'name_route'=>'builder.index' 
            ]
        );

        //menambahkan role admin ke setting menu
        MenuHasRole::firstOrCreate(
            [
                'id_menu' => $menuBuilder->id, 
                'id_roles' => $role->id,
                'ket' => 'role admin memiliki menu tools builder'
            ]
        );

         //buat menu kategori general
        $general =  Menu::firstOrCreate(
            [
                'name'=> 'sukoati',
                'order' =>3
            ]
        );

        echo 'sukses install sukoati-admin (username = "sukoatiadmin@mail.com" password = "password" )' . "\n";
    }
}
