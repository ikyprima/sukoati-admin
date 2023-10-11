<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuHasRole;

class buatAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buat:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat Admin Baru';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permission = Permission::firstOrCreate(
            [
                'name'=> 'view admin'
            ]
        );

        $role =  Role::firstOrCreate(
                [
                    'name'=> 'admin'
                ]
        );
        $role->givePermissionTo($permission->name);
        
        $user = User::updateOrCreate([
            'username' => 'administrator',
    
            ], [
            'email' => 'administrator@mail.com',
            'name' =>  'admin',
            'password' => bcrypt('12345678')
        
        ]);
        
        $user->assignRole(['admin']);

        //membuat kategori menu
        $menu =  Menu::firstOrCreate(
            [
                'name'=> 'setting', //Kategori Setting
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


        echo 'sukses generate admin(administrator@mail.com password = 12345678 )' . "\n";
    }
}
