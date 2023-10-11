<?php

namespace App\Traits;
use App\Models\RuteHasPermission;
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
}