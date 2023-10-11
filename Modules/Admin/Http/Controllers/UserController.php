<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Validator;
use Illuminate\Support\MessageBag;
use Redirect;

use App\Models\User;
use App\Models\Permission;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $permission = Permission::all();
        $user=User::with('roles')->paginate(10)->through(function($item)use($permission){
            $role = collect($item->roles)->map(function ($details,$key){
            return collect([
                "id" => $details->id,
                "name" => $details->name,
                "guard_name" => $details->guard_name
                ]);
            })->pluck('id');
            $directpermission = $item->getDirectPermissions()->pluck('id');
            $permissionviaroles =  $item->getPermissionsViaRoles()->pluck('id');
            $allpermission =  $item->getAllPermissions()->pluck('id');
            return collect([
                'id' => $item->id,
                'name' => $item->name,
                'username' => $item->username,
                'email' => $item->email,
                'email_verified_at' => $item->email_verified_at,
                'status' =>$item->status,
                'role' =>$role,
                'permission' => $permission->whereNotIn('id',$permissionviaroles)->values(), //master permission yang bisa dijadikan direct permission pada user interface (vue)
                'id_directpermission'=>$directpermission,
                'id_permissionviaroles' => $permissionviaroles,
                'id_allpermission' => $allpermission,
                'created_at'=>$item->created_at
            ]);
        });
        $role = Role::with('permissions')->get();
        $permission = Permission::all();
        
        return Inertia::render('Admin/Users',[
            'listuser'=>$user,
            'role'=>$role,
            'permission'=>$permission
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
                'name' => ['required'],
                'username' => [
                    'required',
                    'unique:App\Models\User,username'
                ],
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'unique:App\Models\User,email'
                ],
                'password' => ['required'],
                // 'role' => ['required'],
            ];
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $user = User::firstOrCreate([
                'username' => $request->username
            ], [
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole($request->role);
            $user->givePermissionTo($request->permission);
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
                'name' => ['required'],
                'username' => [
                    'required',
                    
                ],
                'email' => [
                    'required',
                    'email',
                
                ],
                'password' => ['required'],
                // 'role' => ['required'],
            ];
            $value = [
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status' => $request->status,
            ];

            if ($request->updatepassword === null) {
                unset($rules['password']);
                unset($value['password']);
            }
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $user = User::updateOrCreate(
                [
                    'id'   => $id,
                ],
                $value
            );
            
            
            $user->syncRoles($request->role);
            $user->syncPermissions($request->permission);
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['name' => [$e->errorInfo[2]]]); //ganti 'role' dengan global error pada file vue
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
        //
        try {
            $user = User::find($id);
            $delete = User::where('id',$id )->delete();
            if ($delete) {
                $user->syncRoles([]);
                $user->syncPermissions([]);
            }
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
            return Redirect::back()->withErrors($errors);
        }
    }
}
