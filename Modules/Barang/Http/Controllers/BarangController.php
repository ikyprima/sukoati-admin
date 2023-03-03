<?php

namespace Modules\Barang\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Barang\Entities\MBarang;
// use Http;

use Illuminate\Support\Facades\Http;
class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('barang::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('barang::create');
    }
    public function listBarang(){
        return MBarang::all();
    }

    public function listBarangTes(){
        $data = array(
            'id'=>1,
            'nama'=>'namas',
            'data'=>[
                ['id'=>2,
                'nama'=>'tes'],
                ['id'=>3,
                'nama'=>'tesss']
                
            ]
        );
        return response()->json($data, 200);
    
    }

    public function initLokasi(Request $request){
        $response = Http::post('https://presensi.payakumbuhkota.go.id/Servicedev/initPresensiTagging', [
            'token' => $request->token,
        
        ])->json();
        

        return response()->json($response, 200);
        
    }
    public function postAbsen(Request $request){
        $post = Http::post('https://presensi.payakumbuhkota.go.id/Servicedev/prosesPresensiTagging', [
            'token' => $request->token,
            'lat'=> $request->lat,
            'lon'=> $request->lon
        ])->json();
        if ($post) {
            # code...
            $data = array(
                'status'=>true,
                'message'=>'sukses'
            );
            return response()->json($data, 200);
        }else{
            $data = array(
                'status'=>false,
                'message'=>'gagal'
            );
            return response()->json($data, 404);
        }
       
    
    }
    

    public function login(Request $request){
        // return $request->all();
        $post = Http::post('https://sso.payakumbuhkota.go.id/module.php/authpyk/service_login.php', [
            'username'=> "01070519921",
            'password'=> "kominfo2019"
        ]);
        
        return $post;

    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('barang::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('barang::edit');
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
