<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ListNamaRoute;
use App\Models\Menu;
use App\Models\MenuItem;
use Session;
use Redirect;
use Inertia\Inertia;
use App\Traits\flattenRecursive;
use App\Traits\buatRecursive;
class MenuController extends Controller
{
    use ListNamaRoute,flattenRecursive,buatRecursive;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        Inertia::share('appName', fn (Request $request) => 'ge');
        $listMenu = Menu::with('menuItem')->orderBy('order', 'asc')->paginate(10)->through(function($item){
            $flatMenuItem = $this->flatRecursive($item->menuItem); //flat semua child menjadi satu array
            $this->resetFlatRecursive(); //reset global variable 
            $flatMenuItem = collect($flatMenuItem)->unique('id'); //ambil satu key id yang sama aja
            return [
                'id'=> $item->id,
                'name'=> $item->name,
                'order'=> $item->order,
                'menu_item'=> $this->ubahRecursive($flatMenuItem)
            ];
            
        });
    
        return Inertia::render('Admin/Menu',['listMenu'=>$listMenu]);
        
    }
    public function updateMenuChild(Request $request, $id){

        try {

            $menu = MenuItem::where('id',$id)->first();
            
            $flatMenuItem = $this->flatRecursive([$menu]); 
            
            $isAdaAnak = collect($flatMenuItem)->pluck('id')->contains($request->id_parent);
            if(!$isAdaAnak){
                $role = MenuItem::updateOrCreate(
                [
                    'id'   => $id,
                ],
                [
                
                    'id_parent' => $request->id_parent,
                
                ],
                );
    
                return back(303);
            }
        
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
