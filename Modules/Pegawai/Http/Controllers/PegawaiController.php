<?php

namespace Modules\Pegawai\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Pegawai\Entities\Pangkat;
use Modules\Pegawai\Entities\Jabatan;
use Modules\Pegawai\Entities\Pendidikan;
use Inertia\Inertia;
use Illuminate\Support\MessageBag;
use Validator;
use Redirect;
use Storage;
use Image;
use DB;
class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    

        $pangkat = Pangkat::all();
        $jabatan = Jabatan::all();
        $pendidikan = Pendidikan::all();

        $pegawai=Pegawai::with(['pangkat','jabatan','pendidikan'])->paginate(10)->through(function($item){
            if ($item->jekel == 1) {
                $jekel = 'Laki-Laki';
            }else {
                $jekel = 'Perempuan';
            }
                return collect([
                    'id' => $item->id,
                    'nik' => $item->nik,
                    'nama' => $item->nama,
                    'jekel' => $jekel,
                    'id_pangkat' => $item->id_pangkat,
                    'pangkat' => $item->pangkat?$item->pangkat->nama_pangkat:'-',
                    'id_jabatan' => $item->id_jabatan,
                    'jabatan' => $item->jabatan?$item->jabatan->nama_jabatan:'-',
                    'id_pendidikan' => $item->id_pendidikan,
                    'pdd' => $item->pendidikan?$item->pendidikan->nama_pendidikan:'-',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
            ]);
        });
        
    
        return Inertia::render('Master/PegawaiIndex',[
            'listPegawai'=> $pegawai,
            'listPangkat'=>$pangkat,
            'listJabatan'=>$jabatan,
            'listPendidikan'=>$pendidikan

        ]);
    }
    
    public function apiProfilePegawai(Request $request , $id){
        $data = Pegawai::where('id',$id)->orWhere('nik',$id)->with(['pangkat','jabatan','pendidikan'])->get();
        if ($data->isNotEmpty()) {
            $response = array(
                'pendidikan' => array(
                    'status' => true,
                    'message' => "sukses",
                    "data" => $data
                )
            );
            return response()->json($response, 200);
        }else {
            $response = array(
                'pendidikan' => array(
                    'status' => false,
                    'message' => "data tidak ditemukan masukan id atau nik ",
                    "data" => []
                )
            );
            return response()->json($response, 200);
        }
    
        
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pegawai::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
        
            $rules = [
                'nik' => [
                    'required',
                ],
                'nama' => [
                    'required',
                ],
                'jekel' => [
                    'required',
                ],
                'id_jabatan' => [
                    'required',
                ],
                'id_pangkat' => [
                    'required',
                ],
                'id_pendidikan' => [
                    'required',
                ],
        
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

                $pegawai = Pegawai::create([
                    'nik'    => $request->nik,
                    'nama'  => $request->nama,
                    'jekel'  => $request->jekel,
                    'id_jabatan'  => $request->id_jabatan,
                    'id_pangkat'   => $request->id_pangkat,
                    'id_pendidikan'    => $request->id_pendidikan
                
                ]);

            
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
        return view('pegawai::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('pegawai::edit');
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
