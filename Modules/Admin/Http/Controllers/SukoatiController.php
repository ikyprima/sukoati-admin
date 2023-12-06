<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Modules\Admin\Facades\Admin;
use Modules\Admin\Entities\SukoAtiModel;
use Inertia\Inertia;
use App\Traits\ListMidleware;
use Auth;
class SukoatiController extends Controller
{
    use ListMidleware;
    public function __construct(Request $request)
    {
        $slug = $this->getSlug($request);
        $midlw = ['role_or_permission:admin|'.$this->namaMidlewarePermission($slug)];
        $this->middleware($midlw);

        
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-index']) || Auth::user()->hasAnyRole(['admin']) ){
            $dataType = Admin::model('DataType')->with(['rows' => function ($query) {
                $query->where('browse', '1');
            }])->where('slug', '=', $slug)->first();
            if (class_exists($dataType->model_name)) {
                // jika model ada
                $model= app($dataType->model_name);
            
            } else {
                // Model tidak ada
                // $model= app('Modules\Admin\Entities\SukoAtiModel');
                // $model->setTableName($dataType->name);
                $model = new SukoAtiModel();
            }
            
            $dataheader = $dataType->rows->map(function($item){
                return [
                    'title'=> $item->display_name,
                    'field'=> $item->field,
                    'type'=> $item->type,
                    'size'=>'auto',
                    'align'=> 'left'
                ];
            });
            $buttonAksi = collect();
            $buttonTambah = false;
            if (Auth::user()->hasAnyPermission([$slug.'-create']) || Auth::user()->hasAnyRole(['admin'])){
                $buttonTambah = true;
            }
            if (Auth::user()->hasAnyPermission([$slug.'-update']) || Auth::user()->hasAnyRole(['admin'])){
                $buttonAksi->push(
                    [
                    'text'=> '',
                    'type'=> 'button',
                    'action'=> 'edit',
                    'class'=> 'border border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]',
                    'icon'=> 'fas fa-lg fa-pencil-alt'
                    ]
                );
            }
            if (Auth::user()->hasAnyPermission([$slug.'-read']) || Auth::user()->hasAnyRole(['admin'])){
                $buttonAksi->push(
                    [
                    'text'=> '',
                    'type'=> 'button',
                    'action'=> 'lihatDetail',
                    'class'=> 'border border-blue-500 hover:bg-emerald-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]',
                    'icon'=> 'fas fa-lg fa-file-alt'
                    ]
                );
            }
            if (Auth::user()->hasAnyPermission([$slug.'-delete']) || Auth::user()->hasAnyRole(['admin'])){
                $buttonAksi->push(
                    [
                        'text'=> '',
                        'type'=> 'button',
                        'action'=> 'hapus',
                        'class'=> 'border  border-blue-500  hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white  focus:z-[1]',
                        'icon'=> 'fas fa-lg fa-trash-alt'
                    ]
                );
            }
        
            $buttonAksi = $buttonAksi->map(function ($item, $index) use ($buttonAksi){
                $indexTerakhir = $buttonAksi->count() - 1;
                if ($buttonAksi->count() === 1) {
                    $item['class'] = $item['class'].' rounded-l-lg rounded-r-lg';
                }else{
                    if($index === 0){
                        $item['class'] = $item['class'].' rounded-l-2xl';
                    }elseif($index  === $indexTerakhir){
                        $item['class'] = $item['class'].' rounded-r-2xl';
                    }
                }
                return $item;
            });
            
            if ($buttonAksi->count() > 0) {
                $aksi =collect( [
                    'title' => 'Aksi',
                    'field' => null,
                    'type' => 'button-group',
                    'data' => $buttonAksi,
                    'size'=> 20,
                    'align'=> 'center'
                ]);
                $header = $dataheader->push($aksi);
            }else{
                $header = $dataheader;
            }
            if ($request->has('search')) {
                $pencarian = $dataheader->pluck('field')->filter();
                $data = $model->query();
                foreach ($pencarian as $pencarian) {
                    $data->orWhere($pencarian, 'like', '%' . $request->search . '%');
                }
                
                $listData = $data->from($dataType->name)
                ->orderBy('id', 'desc')
                ->paginate(10);
                $listData->appends ( array (
                    'search' => $request->search
                ) );
                
            }else{
                $listData = $model->from($dataType->name)
                ->orderBy('id', 'desc')
                ->paginate(10);
            }
            return Inertia::render('Admin/Sukoati/Index',[
                'header'=>$header,
                'buttonTambah'=>$buttonTambah,
                'slug' =>  $slug,
                'data'=> $listData,
                'dataSearch'=> $request->search,
                'titleTable'=> $dataType->display_name_singular,
                
            ]);

        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    { 
        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-create']) || Auth::user()->hasAnyRole(['admin']) ){
        $dataType = Admin::model('DataType')->with(['rows'])->where('slug', '=', $slug)->first();

        $shema= $dataType->rows->flatMap(function($item){
        $rules = [];
        if($item->required === 1){
            array_push($rules,'required');
        }
        if ($item->add === 1) {
            # code...
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
        }
            
        });
        $shema['element']=[
                'type'=> 'button',
                'button-label'=>'Simpan',
                'align'=>'right',
                'submits'=>true
                
            ];
         $container = collect(
            ['container'=> [
                'type'=> 'group',
                'schema'=> $shema
            ]]
        );
        return Inertia::render('Admin/Sukoati/Add',[
            'formContainer'=>$container,
            'action' =>  $slug,
            'display_name'=>$dataType->display_name_singular
        ]);
        
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-create']) || Auth::user()->hasAnyRole(['admin']) ){
            try {
                
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
                return back(303)->with(['message'=>'Sukses Simpan Data']);
            } catch (\Illuminate\Database\QueryException $e) {
                $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
                return back()->withErrors($errors);
            }
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            return [$id];
        }else{
            return 'bukan ajax ok';
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return 'edit form';
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
