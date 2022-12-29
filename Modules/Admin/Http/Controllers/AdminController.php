<?php

namespace Modules\Admin\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

use Auth;
use App\Models\Permission;
use App\Traits\ListNamaRoute;



class AdminController extends Controller
{
    use ListNamaRoute;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
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

        $menu = $group->push($menuDashboard);
         return $menu->sortBy('order')->values()->all();
       
        return $this->namaRoute();
    


        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
