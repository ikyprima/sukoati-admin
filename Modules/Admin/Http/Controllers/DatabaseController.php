<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

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
use Modules\Admin\Events\TableAdded;
use Modules\Admin\Events\TableDeleted;
use Modules\Admin\Events\TableUpdated;
use Modules\Admin\Facades\Admin;

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

        $tables =  collect(SchemaManager::listTableNames())->map(function($table) use ($dataTypes) {
            return [
                'prefix' => DB::getTablePrefix(),
                'name' => $table,
                'slug' => $dataTypes[$table]['slug'] ?? null,
                'dataTypeId' => $dataTypes[$table]['id'] ?? null,
            ];
        });

        return Inertia::render('Admin/Database/Index',[
            'dataTypes'=>$dataTypes,
            'tables'=>$tables
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
        $conn = 'database.connections.'.config('database.default');
        Type::registerCustomPlatformTypes();
        $table = $request->all();
        $table['options']['collate'] = config($conn.'.collation', 'utf8mb4_unicode_ci');
        $table['options']['charset'] = config($conn.'.charset', 'utf8mb4');
        $table['fkConstraints']=[];
        $table = Table::make($table);
        SchemaManager::createTable($table);
        Artisan::call('make:migration', [
            'name'    => 'create_'.$table->name.'_table',
            '--table' => $table->name,
        ]);

        
        // return response()->json($request->all());
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

    protected function prepareDbManager($action, $table = '')
    {
        $db = new \stdClass();

        // Need to get the types first to register custom types
        $db->types = Type::getPlatformTypes();

        if ($action == 'update') {
            $db->table = SchemaManager::listTableDetails($table);
            $db->formAction = route('voyager.database.update', $table);
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