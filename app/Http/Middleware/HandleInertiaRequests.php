<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Auth;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

        $permissions = $user->permissions;

        $arrRolePermissions = collect(); // permission didalam role
        $arrPermissionMenu = collect(); //menu has permission
        $arrRoleMenu = collect(); //menu has role
        // $user->roles->append(['menurole']); //append atribute role
        $user->roles->map(function($item) use (&$arrRolePermissions,&$arrRoleMenu){

            $detMenuRolePermission = $item->permissions->map(function($item) use (&$arrRolePermissions){  
                $arrRolePermissions->push($item);
            });

            $detMenuRole =  $item->menurole->map(function($item) use (&$arrRoleMenu){
                $arrRoleMenu->push($item);
            });
        });
       
    
        // $user['menu'] = $permissions->merge($arrRolePermissions);
        
        $listMenu = $permissions->merge($arrRolePermissions);  //gabung semua permission dari role dan dari user
        
         $menu =  $listMenu->map(function($item) use (&$arrPermissionMenu){ //list menu dari permission dan permission di dalam role
            $menu  = $item->menu->map(function($item)use (&$arrPermissionMenu){
                
                $item = collect([
                    "id"=> $item->menuitem->id,
                    "id_menu"=>$item->menuitem->id_menu,
                    "title"=>$item->menuitem->title,
                    "url"=>$item->menuitem->url,
                    "name_route"=>$item->menuitem->name_route,
                    "icon"=>$item->menuitem->icon,
                    "deleted_at"=>$item->menuitem->deleted_at,
                    "created_at"=>$item->menuitem->created_at,
                    "updated_at"=>$item->menuitem->updated_at,
                    "menu"=>collect($item->menuitem->menu)]
                );
                $arrPermissionMenu->push($item);
                
            });
            
        });

        
        
        $menuRole = $arrRoleMenu->map(function($item){ //list menu dari role
            return [
                "id"=> $item->menuitem->id,
                "id_menu"=>$item->menuitem->id_menu,
                "title"=>$item->menuitem->title,
                "url"=>$item->menuitem->url,
                "name_route"=>$item->menuitem->name_route,
                "icon"=>$item->menuitem->icon,
                "deleted_at"=>$item->menuitem->deleted_at,
                "created_at"=>$item->menuitem->created_at,
                "updated_at"=>$item->menuitem->updated_at,
                "menu"=>collect($item->menuitem->menu)
            ];
        });
        
        $menucollect = collect();
        $menucollect = $menucollect->merge($arrPermissionMenu->unique());
        $menucollect = $menucollect->merge($menuRole);
        // return $menucollect;
        
        $group =  $menucollect->groupBy(function($item,$key){
            return $item['id_menu'];
        })->map(function($item,$key){
            $header = $item->first();
            $menu = array(
                'id_header' => $header['menu']['id'],
                'header' => $header['menu']['name'],
                'order' => $header['menu']['order'],
                'menu' => $item->map(function($item){
                    return [
                        'id'=> $item['id'],
                        'title'=> $item['title'],
                        'url'=> $item['url'],
                        'name_route'=> $item['name_route'],
                        'icon'=> $item['icon']
                    ];
                
                })
            );
            return $menu;
        
        })->sortBy('order')->values();

        $menuDashboard = collect([
            'id_header' => 0,
            "header"=> "Home",
            "order"=> 0,
            "menu" => array(
                [
                    "id"=> 1,
                    "title"=> "Dashboard",
                    "url"=> "dashboard",
                    "name_route"=> "dashboard",
                    "icon"=> null
                ]
            )
            ]

        );
            $menu = $group->push($menuDashboard)->sortBy('order')->values()->all();
            // $menu=[];
        }else{
            $menu=[];
        }
    

        return array_merge(parent::share($request), [
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'tes' => fn () => $request->session()->get('tes'),
                'appName' => $request->session()->get('tesd'),
            ],
            'appName' => 'appNames',
        
            'auth' => [
                'user' => $request->user(),
                'can' => $request->user() ? $request->user()->getAllPermissions()->pluck('name') : null,
            ],
            'menu' => $menu,
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
