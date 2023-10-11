<?php

namespace App\Traits;
use Route;
trait listController{
    public function namaControllerDanFunction(){

        $rute =collect(Route::getRoutes()->getRoutes());
        return $rute->map(function($item){
            $action = collect($item->getAction());
            if ( $action->has('controller'))
            {
                $start = strrpos($action['controller'], '\\') + 1; // Mencari posisi karakter terakhir dari '\'
                $end = strpos($action['controller'], '@'); // Mencari posisi karakter '@'
                $controllerName = substr($action['controller'], $start, $end - $start); // Memotong string berdasarkan posisi karakter
            
                $parts = explode('\\', $action['controller']);  
                $className = end($parts);

                return [
                    'fullRoute' => $action['controller'],
                    'controller'=>$controllerName,
                    'function' =>$className,
                    'namaRoute'=>$action['as']
                ];
            }
                
            })->filter()->values();
    }
    public function namaController(){
        //nama controller spesifik path
        $controllers = require_once base_path('vendor/composer/autoload_classmap.php');
        $controllers = array_keys($controllers);
        $controllers = array_filter($controllers, function ($controller) {
            return strpos($controller, 'Modules\Pegawai\Http\Controllers') !== false;
        });

        $controllers = array_map(function ($controller) {

            return str_replace('Modules\Pegawai\Http\Controllers\\', '', $controller);
        }, $controllers);
        return $controllers;
    
    } 
}