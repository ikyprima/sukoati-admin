<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ListNamaRoute;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuHasRole;
use App\Models\MenuHasPermission;
use App\Models\Role;
use App\Models\Permission;
use Session;
use Illuminate\Support\MessageBag;
use Redirect;
use Inertia\Inertia;
use App\Traits\flattenRecursive;
use App\Traits\buatRecursive;
use App\Traits\ListController;
use App\Traits\ListMidleware;
use Validator;
class MenuController extends Controller
{
    use ListNamaRoute,flattenRecursive,buatRecursive,ListController,ListMidleware;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $midlw = ['role_or_permission:admin|'.$this->namaMidleware(class_basename(get_class($this)))];
        $this->middleware($midlw);
    }
    public function index(Request $request)
    {
        Inertia::share('appName', fn (Request $request) => 'ge');
        $role = Role::with('permissions')->get();
        $permission = Permission::all();
        $listMenu = Menu::with('menuItem.permission','menuItem.role')->orderBy('order', 'asc')->paginate(10)->through(function($item){
        
            $flatMenuItem = $this->flatRecursive($item->menuItem); //flat semua child menjadi satu array
            $this->resetFlatRecursive(); //reset global variable 
            
            $flatMenuItem = collect($flatMenuItem)->unique('id'); //ambil satu key id yang sama aja
            return [
                'id'=> $item->id,
                'name'=> $item->name,
                'posisi' => $item->kategori,
                'order'=> $item->order,
                'menu_item'=> $this->ubahRecursive($flatMenuItem)
            ];
            
        });
        // return $this->namaRoute();
        return Inertia::render('Admin/Menu',[
            'listMenu'=>$listMenu,
            'role'=>$role,
            'permission'=>$permission,
            'namaRoute'=>$this->namaRoute()
        ]);
        
    }

    public function updateMenu(Request $request, $id){
            try{
                $isKategori = $request->is_kategori;

                if ($isKategori === 1) {
                    //jika kategori dan sub menu
                    
                        $rules = [
                            'kategori' => [
                                'required',
                            ],
                            'menuItem.*.nama_menu' => [
                                'required',
                            ],
                        ];
                        $customMessages = [
                            'required' => 'field harus di isi.'
                        ];
            
                        $validator = Validator::make($request->all(), $rules, $customMessages)
                        ->validate();

                        Menu::where('id',$id)->update(
                            [
                                'kategori' => $request->posisi,
                                'name' => $request->kategori
                            ],
                        );
                    
                        foreach ($request->menuItem as $key => $item) {
                
                            if (array_key_exists("is_diHapus",$item)){
                                $is_diHapus = $item['is_diHapus'];
                            }else{
                                $is_diHapus = false;
                            }
                        
                            if ($is_diHapus == true) {
                                MenuItem::where('id', $item['id_menu'] )
                                ->orWhere('id_parent', $item['id_menu'])
                                ->delete();

                            }else{
                                menuItem::where('id',$item['id_menu'])->update(
                                    [
                                        'title' => $item['nama_menu'],
                                        'url' => $item['nama_route']?$item['nama_route']['url']:null,
                                        'name_route'=> $item['nama_route']?$item['nama_route']['nama']:null
                                    ],
                                );
                            }
                            
                            MenuHasPermission::where('id_menu', $item['id_menu'] )
                            ->delete();
                            MenuHasRole::where('id_menu', $item['id_menu'] )
                            ->delete();
                            if(count($item['permission']) > 0){

                                foreach ($item['permission'] as $keypermission => $valpermsission) {
                                    $menuHasPermission = MenuHasPermission::firstOrCreate([
                                        'id_menu' =>  $item['id_menu'],
                                        'id_permissions' =>  $valpermsission
                                    ]);
                                }
                            }
                            if(count($item['role']) > 0){
                                foreach ($item['role'] as $keyrole => $valrole) {
                                    $menuHasRole = MenuHasRole::firstOrCreate([
                                        'id_menu' =>  $item['id_menu'],
                                        'id_roles' => $valrole
                                    ]);
                                }
                            }
                        }
                        return back(303);
                }else{
                    //jika sub menu dan sub menunya pula
                }
            }catch(\Illuminate\Database\QueryException $e){
            
                $text= $e->getMessage();
                $errors = new MessageBag(['global' => [$e->errorInfo[2]]]);
                return Redirect::back()->withErrors($errors);
            }
    }

    public function updateMenuChild(Request $request, $id){

        try {

            $isParent = $request->is_parent;

            $menu = MenuItem::where('id',$id)->get();
            $flatMenuItem = $this->flatRecursive($menu); 
            $this->resetFlatRecursive(); 
        
            $isAdaAnak = collect($flatMenuItem)->pluck('id')->contains($request->id_parent);

            if(!$isAdaAnak){
                $menuItem = MenuItem::updateOrCreate(
                [
                    'id'   => $id,
                ],
                [
                
                    'id_parent' => $request->id_parent,
                    'id_menu' => $request->id_menu
                
                ],
                );
                MenuItem::where('id_parent',$id)->update(
            
                    [
                        'id_menu' => $request->id_menu,
                    ],
                );
                if ($isParent == 1) {

                
                    if (!MenuItem::where('id_parent', '=', $id)->exists()) {
                          //update is_paren tabel menu_item 
                        MenuItem::where('id',$id)->update(
                            [
                                'is_parent' => 0,
                                'id_menu' => $request->id_menu
                            ],
                        );
                        }
                }
                return back(303);
            }
        
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
        
    }

    public function updateMenuParent(Request $request, $id){

        try {

            MenuItem::where('id',$id)->update(
            
                [
                    'id_menu' => $request->id_menu,
                    'is_parent' => 1,
                    'id_parent' => null
                ],
            );

            MenuItem::where('id_parent',$id)->update(
            
                [
                    'id_menu' => $request->id_menu,
                ],
            );


            

            return back(303);
        
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
        
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
    
        $order = Menu::max('order');
        // return $request->all();
        try{
            $rules = [
                'kategori' => [
                    'required',
                ],
                'menuItem.*.nama_menu' => [
                    'required',
                ],
            ];
            $customMessages = [
                'required' => 'field harus di isi.',
                'unique'=> 'field sudah terdaftar',
                'email'=> 'format field salah'
            ];

            if($request->id !== null){
                unset($rules['kategori']);
            }
            $validator = Validator::make($request->all(), $rules, $customMessages)
            ->validate();

            if($request->id !== null){
                $id_menu = $request->id;
            }else{
                $menu = Menu::firstOrCreate([
                    'name' => $request->kategori,
                ], [
                    'order'=> $order + 1,
                    'kategori' => $request->posisi, //0 = Admin Dashboard 1 = Home Page
                ]);

                $id_menu = $menu->id;
            }

            foreach ($request->menuItem as $key => $item) {

                $menuItem = MenuItem::firstOrCreate([
                    'title' =>  $item['nama_menu'],
                    'id_menu' => $id_menu,
                ], [
                    'is_parent' => 1,
                    'is_allow_drag' => 1,
                    'url' =>$item['nama_route']?$item['nama_route']['url']:null,
                    'name_route'=> $item['nama_route']?$item['nama_route']['nama']:null
                ]);

                if(count($item['permission']) > 0){
                    foreach ($item['permission'] as $keypermission => $valpermsission) {
                        $menuHasPermission = MenuHasPermission::firstOrCreate([
                            'id_menu' =>  $menuItem->id,
                            'id_permissions' =>  $valpermsission
                        ]);
                    }
                }

                if(count($item['role']) > 0){
                    foreach ($item['role'] as $keyrole => $valrole) {
                        $menuHasRole = MenuHasRole::firstOrCreate([
                            'id_menu' =>  $menuItem->id,
                            'id_roles' => $valrole
                        ]);
                    }
                }
            }
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['menu' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
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

    //---
    public function listData(){
        $menu = Menu::orderBy('order','ASC')->with('menuItem')->get()
        ->map(function($item){
            $flatMenuItem = $this->flatRecursive($item->menuItem); //flat semua child menjadi satu array
            $this->resetFlatRecursive(); //reset global variable 
            $flatMenuItem = collect($flatMenuItem)->unique('id'); //ambil satu key id yang sama aja
            return [
                'id'=> $item->id,
                'name'=> $item->name,
                'order'=> $item->name,
                'menu_item'=> $this->ubahRecursive($flatMenuItem)
            ];
        });
        return $menu;
    }
}
