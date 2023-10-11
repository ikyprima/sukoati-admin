<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use App\Traits\listMidleware;
use App\Models\Permission;
use Auth;
use Validator;
use Illuminate\Support\MessageBag;
use Redirect;
class PermissionController extends Controller
{
    use listMidleware;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        // $midlw = ['role_or_permission:admins|'.$this->namaMidleware(class_basename(get_class($this)))];
        // $this->middleware(['permission:update permission']);
    }
    public function index(Request $request)
    {
    
        $permission = Permission::with('rute')->paginate(10)->through(function($item){
            return collect([
            
                'guard_name'=>$item->guard_name,
                'id'=>$item->id,
                'name'=>$item->name,
                'controller'=>$item->rute?$item->rute->controller:'-',
                'function'=>$item->rute?$item->rute->function:'-'
            
            ]);
        });
        return Inertia::render('Admin/Permissions',[
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
                'permission' => [
                    'required',
                ],
            ];
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $permission = Permission::firstOrCreate([
                'name' => $request->permission
            ]);
            return back(303);

        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['permission' => [$e->errorInfo[2]]]);
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
                'permission' => [
                    'required',
                ],
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $permission = Permission::where('id',$id)->update(
            
                [
                
                    'name' => $request->permission,
                
                ],
            );
    
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['permission' => [$e->errorInfo[2]]]);
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

            Permission::where('id',$id )
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
