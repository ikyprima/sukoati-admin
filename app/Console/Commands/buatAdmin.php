<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        echo 'sukses generate admin' . "\n";
    }
}
