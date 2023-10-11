<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Master\Entities\Kategori;
use Modules\Master\Entities\Satuan;
use Modules\Master\Entities\Barang;
use Illuminate\Support\MessageBag;
use Validator;
use Redirect;
use Storage;
use Image;
use DB;
class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $kategori = Kategori::all();
        $satuan =Satuan::all();
        $barang=Barang::with('satuan')->paginate(10)->through(function($item){
                return collect([
                    'id' => $item->id,
                    'sku' => $item->sku,
                    'nama' => $item->nama,
                    'barcode' => $item->barcode,
                    'merk' => $item->merk,
                    'stok_min' => $item->stok_min,
                    'id_kategori' => $item->id_kategori,
                    'kategori' => $item->kategori?$item->kategori->nama:'-',
                    'id_satuan' => $item->id_satuan,
                    'satuan' => $item->satuan?$item->satuan->nama:'-',
                    'photo' => $item->photo,
                    'keterangan' => $item->keterangan,
                    'deleted_at' => $item->deleted_at,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                
            ]);
        });
        return Inertia::render('Master/BarangIndex',[
            'listKategori'=>$kategori,
            'listSatuan'=>$satuan,
            'listBarang'=>$barang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

    
        // $request->validate([
        //     'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        // ]);
        try {
            $rules = [
                'nama' => [
                    'required',
                ],
                'id_kategori' => [
                    'required',
                ],
                'id_satuan' => [
                    'required',
                ],
                // 'photo' =>[
                //     'nullable',
                //     'image',
                //     'mimes:jpeg,png,jpg,JPG',
                //     'max:10028'
                // ]
                
                
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah',
                'image'=> 'format :attribute salah',
                'mimes'=> 'format :attribute jpeg,jpg,png',
                'max'=> 'ukuran :attribute max 1028'

        
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();


            return  DB::transaction(function ($q) use ($request) {

                if (!Storage::disk('public')->exists('barang')) {
                
                    Storage::disk('public')->makeDirectory('barang');

                }

                $barang = Barang::create([
                    'sku'    => $request->sku,
                    'nama'  => $request->nama,
                    'merk'  => $request->merk,
                    'barcode'  => $request->barcode,
                    'stok_min'   => $request->stok_min,
                    'id_kategori'    => $request->id_kategori,
                    'id_satuan'    => $request->id_satuan,
                    'keterangan' => $request->keterangan,
                ]);

                if ($request->hasFile('photo')) {
                    $image      = $request->file('photo');
                    $fileName   = time() . '.' . $image->extension();
                
                    $img = Image::make($image->getRealPath());
                    $img->stream(); // <-- Key point
                    Storage::disk('public')->put('barang'.'/'.$fileName, $img, 'public');

                    $img->resize(200, 200, function ($constraint) {
                        // $constraint->aspectRatio();                 
                    });
                    $img->stream(); // <-- Key point
                    Storage::disk('public')->put('barang/smalls'.'/'.$fileName, $img, 'public');

                    Barang::where('id', $barang->id)
                    ->update([
                        'photo'     => $fileName,
                    
                    ]);
                }
                return back(303);
                
            });

        } 
        catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
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
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('master::edit');
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
                'nama' => [
                    'required',
                ],
            ];
            
            
            $customMessages = [
                'required' => ':attribute harus di isi.',
                'unique'=> ':attribute sudah terdaftar',
                'email'=> 'format :attribute salah'
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
            $Kategori = Kategori::where('id',$id)->update(
            
                [
                
                    'nama' => $request->nama,
                    'singkatan' => $request->singkatan,
                
                ],
            );
    
            return back(303);
        } catch(\Illuminate\Database\QueryException $e){
            // return dd($e);
            $text= $e->getMessage();
            $errors = new MessageBag(['nama' => [$e->errorInfo[2]]]);
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
    }
}
