<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use App\Models\Role;
use Validator;
use Illuminate\Support\MessageBag;
use Redirect;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $role=Role::with('permissions')->paginate(10);
        $role = $role->through(function ($item){
            $permission = collect($item->permissions)->map(function ($details,$key){
                return collect([
                    "id" => $details->id,
                    "name" => $details->name,
                    "guard_name" => $details->guard_name
                ]);
            });
            return collect([
                'id' => $item->id,
                'name' => $item->name,
                'guard_name'=>$item->guard_name,
                'permission' =>$permission,
                'created_at'=>$item->created_at
            ]);
        });
        $permission = Permission::all();
        // return Inertia::render('Admin/tes');
        return Inertia::render('Admin/Role',[
            'role'=>$role,
            'permission'=> $permission
        ]);
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
        try{
            $rules = [
                'role' => [
                    'required',
                ],
            ];
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $role = Role::firstOrCreate([
                'name' => $request->role
            ]);
            $role->givePermissionTo($request->permission);

            return back(303);

        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['role' => [$e->errorInfo[2]]]);
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
        try {
            $rules = [
                'role' => [
                    'required',
                ],
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
        
            $role = Role::updateOrCreate(
                [
                    'id'   => $id,
                ],
                [
                
                    'name' => $request->role,
                
                ],
            );
       
            $role->syncPermissions($request->permission);
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['role' => [$e->errorInfo[2]]]); //ganti 'role' dengan global error pada file vue
            return Redirect::back()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            Role::where('id',$id )
            ->delete();
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    
    }
}
