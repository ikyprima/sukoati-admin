<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\MessageBag;
use Modules\Admin\Facades\Admin;
class SukoatiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $slug = $this->getSlug($request);

        
        $dataType = Admin::model('DataType')->with(['rows' => function ($query) {
            $query->where('browse', '1');
        }])->where('slug', '=', $slug)->first();


        if (class_exists($dataType->model_name)) {
            // jika model ada
            $model= app($dataType->model_name);
        
        } else {
            // Model tidak ada
            $model= app('Modules\Admin\Entities\SukoAtiModel');
            $model->setTableName($dataType->name);
        }
        
        
        $header = $dataType->rows->map(function($item){
            return [
                'title'=> $item->display_name,
                'field'=> $item->field,
                'type'=> $item->type,
                'size'=>'auto',
                'align'=> 'left'
            ];
        });
        $data = $model->get();
        return Inertia::render('Admin/Sukoati/Index',[
            'header'=>$header,
            'data'=> $data,
            'titleTable'=> $dataType->display_name_singular,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    { 
        $slug = $this->getSlug($request);
        $dataType = Admin::model('DataType')->with(['rows' => function ($query) {
            $query->where('browse', '1');
        }])->where('slug', '=', $slug)->first();

        $shema= $dataType->rows->flatMap(function($item){
        $rules = [];
        if($item->required === 1){
            array_push($rules,'required');
        }
            return [
                $item->field =>[
                    'type'=> $item->type,
                    'label' => $item->display_name,
                    'floating' => false,
                    'placeholder' => $item->display_name,
                    'fieldName' => $item->display_name,
                    'rules' => $rules,
                    'columns' => array(
                        'container' => 6,
                        'label' => 12,
                        'wrapper' => 12,
                    ),
                    'overrideClass' => array(
                        'inputContainer' => 'border border-gray-300 w-full transition-all rounded-lg shadow-sm',
                        'inputContainer_default' => 'border-black',
                        'inputContainer_focused' => '',
                        'inputContainer_md' => '',
                    ),
                    'addClasses' => array(
                        'ElementLabel' => array(
                            'container' => 'block font-medium text-sm text-gray-700',
                        ),
                        'TextElement' => array(
                            'input' => 'rounded-lg shadow-sm',
                        ),
                    ),

                ]
            ];
        });
        
        $container = collect(
            ['container'=> [
                'type'=> 'group',
                'schema'=> $shema
            ]]
        );
        return Inertia::render('Admin/Sukoati/Add',[
            'formContainer'=>$container,
            'action' =>  $slug.'.store'
        ]);
    
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            
            $slug = $this->getSlug($request);
            $dataType = Admin::model('DataType')->where('slug', '=', $slug)->first();

            if (class_exists($dataType->model_name)) {
                // jika model ada
                $model= app($dataType->model_name);
            
            } else {
                // Model tidak ada
                $model= app('Modules\Admin\Entities\SukoAtiModel');
                $model->setTableName($dataType->name);
            }
            $model->create($request->all());
            return back(303);
        } catch (\Illuminate\Database\QueryException $e) {
            $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
            return back()->withErrors($errors);
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

}
