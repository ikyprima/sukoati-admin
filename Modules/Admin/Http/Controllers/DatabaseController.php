<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Illuminate\Support\MessageBag;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Admin\Database\DatabaseUpdater;
use Modules\Admin\Database\Schema\Column;
use Modules\Admin\Database\Schema\Identifier;
use Modules\Admin\Database\Schema\SchemaManager;
use Modules\Admin\Database\Schema\Table;
use Modules\Admin\Database\Types\Type;
use Modules\Admin\Facades\Admin;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $dataTypes = Admin::model('DataType')->select('id', 'name', 'slug')->get()->keyBy('name')->toArray();
        // $tables = array_map(function ($table) use ($dataTypes) {
        //     $table = Str::replaceFirst(DB::getTablePrefix(), '', $table);

        //     $table = [
        //         'prefix' => DB::getTablePrefix(),
        //         'name' => $table,
        //         'slug' => $dataTypes[$table]['slug'] ?? null,
        //         'dataTypeId' => $dataTypes[$table]['id'] ?? null,
        //     ];

        //     return (object) $table;
        // }, SchemaManager::listTableNames());

        // $tables =  collect(SchemaManager::listTableNames())->map(function($table) use ($dataTypes) {
        //     return [
        //         'prefix' => DB::getTablePrefix(),
        //         'name' => $table,
        //         'slug' => $dataTypes[$table]['slug'] ?? null,
        //         'dataTypeId' => $dataTypes[$table]['id'] ?? null,
        //     ];
        // });

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

        return Inertia::render('Admin/Database/Index',[
            'dataTypes'=>$dataTypes,
            'tables'=>collect($tables)->values()
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        $dataTypes = $this->prepareDbManager('create');
        return Inertia::render('Admin/Database/Add',['dataTypes'=>$dataTypes,]);
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    
        try {

            $conn = 'database.connections.'.config('database.default');
            Type::registerCustomPlatformTypes();
            $table = $request->all();
            $table['options']['collate'] = config($conn.'.collation', 'utf8mb4_unicode_ci');
            $table['options']['charset'] = config($conn.'.charset', 'utf8mb4');
            $table['fkConstraints']=[];
            $table = Table::make($table);
            SchemaManager::createTable($table);
            return to_route('database.index')->with(['message'=>'Sukses Simpan Data']);
            
        } catch(\Illuminate\Database\QueryException $e){
            $text= $e->getMessage();
            $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
            return back()->withErrors($errors);
        }
    
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request,$id)
    {

    //     $fkColumns = Schema::getConnection()
    //     ->getDoctrineSchemaManager()
    //     ->listTableForeignKeys('orders');

    // return collect($fkColumns)->map(function ($fkColumn) {
    //     return $fkColumn->getColumns();
    // });

        if($request->ajax()){
            $table = collect(SchemaManager::describeTable($id));
            return $table;
        }else{
            return to_route('database.index');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($table)
    {
        if (!SchemaManager::tableExists($table)) {
            return 'tidak ada table';
            
        }
        $db = $this->prepareDbManager('update', $table);
        return Inertia::render('Admin/Database/Add',
        [
            'dataTypes'=>$db->types,
            'tables'=>$db->table,
            'action' => $db->action
        
    ]);
       
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        try {

            Type::registerCustomPlatformTypes();
            $table = $request->all();
            DatabaseUpdater::update($table);
            return to_route('database.index')->with(['message'=>'Sukses Update Data']);
            // return redirect()->route('database.index');
            
        } catch(\Illuminate\Database\QueryException $e){
            $text= $e->getMessage();
            $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
            return back()->withErrors($errors);
        }
    
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($table)
    {
        try {
            SchemaManager::dropTable($table);
            return back(303);
        } catch (Exception $e) {
            $errors = new MessageBag(['error' => [$e->getMessage()]]);
            return back()->withErrors($errors);
        }
    }

    protected function prepareDbManager($action, $table = '')
    {
        $db = new \stdClass();

        // Need to get the types first to register custom types
        $type = Type::getPlatformTypes();
        $db->types =$type;

        if ($action == 'update') {
            $indexes = collect();
            $columns = SchemaManager::describeTable($table)->map(function($item,$key)use($type,&$indexes,$table){
                $nametype = $item['type'];
                $objectType = $type->flatMap(function ($items) use ($nametype) {
                    return collect($items)->filter(function ($item) use ($nametype) {
                        return $item['name'] === $nametype;
                    });
                })->first();

                collect($item['indexes'])->values()->map(function($item) use(&$indexes, $table){
                    $item["table"] = $table;
                    $indexes->push($item);
                });
                
                return [
                    'name' => $item['name'],
                    'oldName' => $item['name'],
                    'type' => $objectType,
                    'length'=>$item['length'],
                    'fixed'=> $item['fixed'],
                    'unsigned'=> $item['unsigned'],
                    'autoincrement'=> $item['autoincrement'],
                    'notnull'=> $item['notnull'],
                    'default'=> $item['default'],
                ] ;
            })->values();
            $varTable = [
                'name'=>$table,
                'oldName' => $table,
                'columns' => $columns,
                'indexes' => $indexes,
                'primaryKeyName'=> 'primary',
                'foreignKeys'=> [],
                'options' => [
                    'create_options' => []
                ]
                    

            ];
            $db->table = $varTable;
            // $db->table = SchemaManager::listTableDetails($table);
            $db->formAction = route('database.update', $table);
        } else {
            $db->table = new Table('New Table');

            // Add prefilled columns
            $db->table->addColumn('id', 'integer', [
                'unsigned' => true,
                'notnull' => true,
                'autoincrement' => true,
            ]);

            $db->table->setPrimaryKey(['id'], 'primary');

            $db->formAction = route('database.store');
        }

        $oldTable = old('table');
        $db->oldTable = $oldTable ? $oldTable : json_encode(null);
        $db->action = $action;
        $db->identifierRegex = Identifier::REGEX;
        $db->platform = SchemaManager::getDatabasePlatform()->getName();

        return $db;
    }
}