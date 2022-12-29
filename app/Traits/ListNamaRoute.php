<?php

namespace App\Traits;
use Illuminate\Support\Facades\Route;
trait listNamaRoute{
    public function namaRoute(){

//         $route_name = [];
//         $routeCollection = Route::getRoutes()->getRoutesByMethod()['GET'];
    //   foreach (Route::getRoutes()->getRoutes() as $route) {
    //       $action = $route->getAction();
    //       if (array_key_exists('as', $action)) {
    //           $route_name[] = $action['as'];
    //       }
    //   }

    $routeCollection = Route::getRoutes();
    $r= collect($routeCollection)->map(function($item){
    
        return [
            'method' => $item->methods()[0],
            'uri' => $item->uri(),
            'nama' => $item->getName(),
            'action' => $item->getActionName()

        ];
    });

    return $r->where('method','GET')->where('nama','!=', null)->values();
    
    }
}