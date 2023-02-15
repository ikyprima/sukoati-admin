<?php

namespace Modules\Barang\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Barang\Entities\MBarang;
use Http;

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
                'nama'=>'tess']
                
            ]
        );
        return response()->json($data, 200);
    
    }

    public function initLokasi(){
        $response = Http::post('https://presensi.payakumbuhkota.go.id/Servicedev/initPresensiTagging', [
            'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJlLWtpbmVyamEucGF5YWt1bWJ1aGtvdGEuZ28uaWQiLCJhdWQiOiJwcmVzZW5zaS5wYXlha3VtYnVoa290YS5nby5pZCIsImV4cCI6MTY3NjQ0MjgzNiwiaWF0IjoxNjczODUwODM2LCJuaXAiOiIwMTA3MDUxOTkyMSJ9.dMd4o7sbcxySbLydmQWLdlJDB5DkVZlp-b4feixeZi7exQxWRVEAwsuhTcYBeNkmqbSQeQRIN_Lnm1Ip8lIYAj56SGwY99aHISbhRAtDleq-Nidipff23bvq4FF632Xvbulx7FAZ9oT6HSC68vql-Gj5gfi5735kP0ZOq4aoapY',
        
        ])->json();
        

        return response()->json($response, 200);
        
    }
    public function postAbsen(Request $request){
        return $request->all();
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
