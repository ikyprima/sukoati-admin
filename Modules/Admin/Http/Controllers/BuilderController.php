<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use DB;
use Str;
use Modules\Admin\Facades\Admin;
use Modules\Admin\Database\Schema\SchemaManager;
use Illuminate\Support\MessageBag;
use Modules\Admin\Entities\DataType;
use Modules\Admin\Entities\DataRow;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuHasRole;
use App\Models\MenuHasPermission;
use Spatie\Permission\Models\Role;
use Event;
use Route;
use App\Models\Permission;
use Modules\Admin\Events\ClearRoute;
class BuilderController extends Controller
{

    public function index()
    {
        // dd(app('App\Models\User'));
        $dataTypes = Admin::model('DataType')->select('id', 'name', 'slug')->get()->keyBy('name')->toArray();

        $tables = array_map(function ($table) use ($dataTypes) {
            $table = Str::replaceFirst(DB::getTablePrefix(), '', $table);

            $table = [
                'prefix'     => DB::getTablePrefix(),
                'name'       => $table,
                'slug'       => $dataTypes[$table]['slug'] ?? null,
                'dataTypeId' => $dataTypes[$table]['id'] ?? null,
            ];

            return (object) $table;
        }, array_diff(SchemaManager::listTableNames(), config('admin.tabelList')) );
    
        return Inertia::render('Admin/Builder/Index',[
            'dataTypes'=> $dataTypes,
            'tables' => collect($tables)->values()
        ]);
    }

    public function create($table)
    {
        
        $dataType = Admin::model('DataType')->whereName($table)->first();
        
        $data = $this->prepopulateBreadInfo($table);

        $data['fieldOptions'] = SchemaManager::describeTable(
            (isset($dataType) && strlen($dataType->model_name) != 0)
            ? DB::getTablePrefix().app($dataType->model_name)->getTable()
            : DB::getTablePrefix().$table
        );
        //  return $data;
        return Inertia::render('Admin/Builder/Add',[
            'data'=> $data,
            'title' => 'tambah form builder'
        ]);
    }


    public function store(Request $request)
    {

        try {
            $dataType = DataType::firstOrCreate([
                'name'=> $request->table
            ], [
                'slug'=> $request->slug,
                'display_name_singular'=> $request->display_name,
                'display_name_plural'=> $request->display_name_plural,
                'model_name'=> $request->model_name,
                'controller'=> $request->table,
            ]);

            $idDataType = $dataType->id;
            $datareject = collect(['created_at','updated_at','deleted_at']);
            $primaryKey = collect( $request->fieldOptions)->where('key','PRI');
            $datareject = $datareject->merge($primaryKey->pluck('field'));
            $data = collect( $request->fieldOptions)->pluck('field');
            $data = $data->reject(function ($value) use ($datareject){
                return  $datareject->contains($value);
            });
            $fillAble = implode(',', $data->toArray());
            $nameModel = Str::singular($request->table);
            $nameTable = $request->table;
            $primaryKeyTable = $primaryKey?$primaryKey->pluck('field')->first() : null;
            foreach ($request->fieldOptions as $key => $item) {

                $dataRows = DataRow::updateOrCreate([
                    'field' =>  $item['field'],
                    'data_type_id' => $idDataType,
                ], [
                    'type' => $item['inputType'],
                    'display_name' => $item['display_name'],
                    'required' => $item['required'],
                    'browse'=> $item['browse'],
                    'read' => $item['read'],
                    'edit'=> $item['edit'],
                    'add' => $item['add'],
                    'delete' => $item['delete'],
                    'order'=> $item['order']
                ]);
            }
            $dataPermission = [
                $request->slug.'-index', 
                $request->slug.'-create',
                $request->slug.'-read', 
                $request->slug.'-update',
                $request->slug.'-delete'
            ];

            foreach ($dataPermission as $key => $value) {
                Permission::firstOrCreate([
                    'name' => $value
                ]);
            }

            Event::dispatch(new ClearRoute());
            
            \Artisan::call('sukoati:buat-model '.$nameModel.' --primarykey='.$primaryKeyTable.' --tablename='.$nameTable.' --fillable='.$fillAble ); 

            $kategoriMenu =  Menu::firstOrCreate(
                [
                    'name'=> 'sukoati',
                    'order' =>3
                ]
            );
            $menuItem =  MenuItem::firstOrCreate(
                [
                    'is_parent'=> 1,
                    'id_menu' => $kategoriMenu->id,
                    'title' => $request->display_name,
                    'url'=>url('/').'/admin'.'/'. $request->slug, 
                    'name_route'=>$request->slug.'.index' 
                ]
            );

            //menambahkan role admin ke menu yang dibuat (role admin otomatis dapat akses menu)
            $role =  Role::firstOrCreate(
                    [
                        'name'=> 'admin'
                    ]
            );
            MenuHasRole::firstOrCreate(
                [
                    'id_menu' => $menuItem->id, //id menu item
                    'id_roles' =>  $role->id,
                    'ket' => 'role admin memiliki menu form '. $request->display_name
                ]
            );
            // tambah permision ke menu (permission index saja);
            $permission = Permission::where('name', $request->slug.'-index')->first();
            MenuHasPermission::firstOrCreate([
                'id_menu' =>  $menuItem->id,
                'id_permissions' =>  $permission->id
            ]);

        //    if (Route::has($request->slug.'.index')) {
        //     return 'tidak ada route';
        //    }else{
            // return ' ada route';
            // Event::dispatch(new ClearRoute());
            // return redirect()->route($request->slug.'.index');
        //     return back(303)->with(['message'=>'Sukses Generate Form']);
        //    }
        
        //    return back(303)->with(['message'=>'Sukses Generate Form']);
            return to_route('builder.index')->with(['message'=>'Sukses Generate Form']);
        } catch (\Illuminate\Database\QueryException $e) {
            $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
            return back()->withErrors($errors);
        }
        
    }


    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($table)
    {
        
        $dataType = Admin::model('DataType')->with('rows')->whereName($table)->first();
        $fieldOptions = SchemaManager::describeTable(
            (strlen($dataType->model_name) != 0)
            ? DB::getTablePrefix().app($dataType->model_name)->getTable()
            : DB::getTablePrefix().$dataType->name
        );

        $tables = SchemaManager::listTableNames();
        $dataTypeRelationships = Admin::model('DataRow')->where('data_type_id', '=', $dataType->id)->where('type', '=', 'relationship')->get();
        $data = compact('dataType', 'fieldOptions', 'tables', 'dataTypeRelationships');
        return Inertia::render('Admin/Builder/Add',[
            'data'=> $data,
            'action' =>'edit',
            'title'=>'edit builder'
        ]);
    
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    private function prepopulateBreadInfo($table)
    {
        $displayName = Str::singular(implode(' ', explode('_', Str::title($table))));
        $modelNamespace = app()->getNamespace().'Models\\Sukoati\\';
        if (empty($modelNamespace)) {
            $modelNamespace = app()->getNamespace();
        }

        return [
            'isModelTranslatable'  => true,
            'table'                => $table,
            'slug'                 => Str::slug($table),
            'display_name'         => $displayName,
            'display_name_plural'  => Str::plural($displayName),
            'model_names'           => $modelNamespace.Str::studly(Str::singular($table)),
            'generate_permissions' => true,
            'server_side'          => false,
        ];
    }
}
