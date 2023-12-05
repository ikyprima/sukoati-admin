<?php

namespace App\Traits;
use App\Models\RuteHasPermission;
use App\Models\Permission;
trait listMidleware{
    public function namaMidleware($controller){
        $rute = RuteHasPermission::with('permission')->where('controller',$controller)->get()->map(
            function($item){
                if ($item->permission) {
                    
                    return $item->permission->name;
                }
            
            }
        )->unique()->toArray();

        $string = implode("|", $rute);
        return $string; //string midleware dari database berdasarkan permission
    
    }
    public function namaMidlewarePermission($slug){
        //get permission berdasrkan slug
        $dataPermission = ['-index','-create','-read','-update','-delete'];
        foreach ($dataPermission as $value) {
            $listPermission[] = $slug . $value;
        }
        $rute = Permission::whereIn('name',$listPermission)->get()->map(
            function($item){
                return $item->name;
            
            }
        )->unique()->toArray();
        $string = implode("|", $rute);
        return $string; //permission untuk midleware
    
    }
}