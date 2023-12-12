<?php

namespace Modules\Admin\Http\Controllers;

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
                    return  collect($this->buatSchema($item,$rules));
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

            // return $container;
            return Inertia::render('Admin/Sukoati/Add',[
                'formContainer'=>$container,
                'slug'=> $slug,
                'action' => '.store',
                'display_name'=>$dataType->display_name_singular
            ]);
        
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
    }

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

    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-update']) || Auth::user()->hasAnyRole(['admin']) ){
            $dataType = Admin::model('DataType')->with(['rows' => function ($query) {
                $query->where('read', '1');
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
                $displayName = $dataType->rows->map(function ($row) {
                    return [
                        'field'=>$row->field,
                        'display_name'=> $row->display_name
                    ];
                });
                $field = $dataType->rows->pluck('field')->filter();
                $data = $model->from($dataType->name)->where('id',$id)->first();
                if ($request->ajax()) {
                    return response()->json([
                        'data' => collect($data)->only($field),
                        'display_name' => $displayName
                    ]);
                }else{
                    return 'bukan ajax ok';
                }
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
        
        
    }


    public function edit(Request $request, $id)
    {

        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-update']) || Auth::user()->hasAnyRole(['admin']) ){
            $dataType = Admin::model('DataType')->with(['rows' => function ($query) {
                $query->where('edit', '1');
            }])->where('slug', '=', $slug)->first();
            
            $shema= $dataType->rows->flatMap(function($item){
                $rules = [];
                if($item->required === 1){
                    array_push($rules,'required');
                }
                if ($item->add === 1) {
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
                
                if (class_exists($dataType->model_name)) {
                    // jika model ada
                    $model= app($dataType->model_name);
                
                } else {
                    // Model tidak ada
                    // $model= app('Modules\Admin\Entities\SukoAtiModel');
                    // $model->setTableName($dataType->name);
                    $model = new SukoAtiModel();
                }
                $field = $dataType->rows->pluck('field')->filter()->push('id');
                $data = $model->from($dataType->name)->where('id',$id)->first();
    
                return Inertia::render('Admin/Sukoati/Add',[
                    'formContainer'=>$container,
                    'slug'=> $slug,
                    'action' => '.update',
                    'display_name'=>$dataType->display_name_singular,
                    'isiData' => collect($data)->only($field)
                ]);
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
        
    }


    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-update']) || Auth::user()->hasAnyRole(['admin']) ){
            try {
                $dataType = Admin::model('DataType')->where('slug', '=', $slug)->first();
                if (class_exists($dataType->model_name)) {
                    // jika model ada
                    $model= app($dataType->model_name);
                } else {
                    // Model tidak ada
                    $model = new SukoAtiModel();
                }
                
                $model->from($dataType->name)->where('id',$id)->update(
                    $request->all()
                );
                return back(303)->with(['message'=>'Sukses Update Data']);
            } catch(\Illuminate\Database\QueryException $e){
                // return dd($e);
                $text= $e->getMessage();
                $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
                // return Redirect::back()->withErrors($errors);
                return back()->withErrors($errors);
            }
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
    
    }


    public function destroy(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        if (Auth::user()->hasAnyPermission([$slug.'-delete']) || Auth::user()->hasAnyRole(['admin']) ){
            try {
                $dataType = Admin::model('DataType')->where('slug', '=', $slug)->first();
                if (class_exists($dataType->model_name)) {
                    // jika model ada
                    $model= app($dataType->model_name);
                } else {
                    // Model tidak ada
                    $model = new SukoAtiModel();
                }
                $model->from($dataType->name)->where('id',$id )
                ->delete();
                return back(303)->with(['message'=>'Sukses Update Data']);
            } catch(\Illuminate\Database\QueryException $e){
                // return dd($e);
                $text= $e->getMessage();
                $errors = new MessageBag(['error' => [$e->errorInfo[2]]]);
                return back()->withErrors($errors);
            }
        }else{
            abort(403, 'Maaf Anda Tidak Ada Permission Untuk Halaman Ini - Silahkan Hubungi Admin');
        }
    }

    private function buatSchema($item,$rules){

        if($item->type == 'Text' || $item->type == 'textarea'){
            return[
                $item->field =>[
                    'type'=> $item->type,
                    'id'=>$item->field,
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
                ]
            ];
        }else if($item->type == 'Date'){
            return[
                $item->field =>[
                    'type'=> $item->type,
                    'id'=>$item->field,
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
                    'addons' => [
                        'before' => ($item->type == 'Date') ? '<i class=\'fas fa-lg fa-calendar-alt mr-2 text-slate-500\'></i>' : '',
                    ]
                ]
            ];
        }else if($item->type == 'radiogroup'){
            
            $detailItem =json_decode($item->details, true) ;
            if (isset($detailItem['item'])) {
                if (isset($detailItem['item']['lokal'])) {
                    $lokalArray = $detailItem['item']['lokal'];
                    $itemRadioLokal = $lokalArray;
                } else {
                    $itemRadioLokal = [];
                }

                if (isset($detailItem['item']['tabel'])) {
                    if (isset($detailItem['item']['tabel']['nama_tabel']) && isset($detailItem['item']['tabel']['value']) && isset($detailItem['item']['tabel']['label'])) {
                        $namaTabel = $detailItem['item']['tabel']['nama_tabel'];
                        $value =  $detailItem['item']['tabel']['value'];
                        $label =  $detailItem['item']['tabel']['label'];
                        $model = new SukoAtiModel();
                        $listData = $model->from($namaTabel)
                        ->get()->map(function($item) use ($value,$label){
                            return [
                                'value'=>$item->{$value},
                                'label'=>$item->{$label}
                            ];
                        });
                    }else{
                        $listData = [];
                    }
                
                    $itemRadioTabel = $listData;
                } else {
                    $itemRadioTabel = [];
                }

                $itemRadio = collect($itemRadioLokal)->merge($itemRadioTabel)->unique('value')->values()->all();
            } else {
                $itemRadio = [];
            }
        
            return[
                $item->field =>[
                    'type'=> $item->type,
                    'label' => $item->display_name,
                    'items'=>$itemRadio,
                    'rules' => $rules,
                    'columns' => array(
                        'container' => 6,
                        'label' => 12,
                        'wrapper' => 12,
                    )
                ]
            ];
        }
    }

}
