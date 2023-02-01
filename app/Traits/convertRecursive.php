<?php

namespace App\Traits;

trait convertRecursive{
    protected $result = [];
    public function convertArrToObj($arr){
    //convert recursive object ke array 
        if ($arr['parent']) {
            $this->result[] = [
                "id" => $arr['id'],
                "title" => $arr['title'],
                "id_parent" => intval($arr['id_parent']),
                "url" => $arr['url'],
                "name_route" => $arr['name_route'],
                "icon" => $arr['icon'],
            ];
            $this->convertArrToObj($arr['parent']);

        }else {
            # code...
            $this->result[] = [
                "id" => $arr['id'],
                "title" => $arr['title'],
                "id_parent" => intval($arr['id_parent']),
                "url" => $arr['url'],
                "name_route" => $arr['name_route'],
                "icon" => $arr['icon'],
            ];
        }

    }

    public function dataObj($data){
    
        $this->convertArrToObj($data);
        
        return $this->result;
    }
    public function resetObj(){
        //reset global variabel
        $this->result=[];
    }
}