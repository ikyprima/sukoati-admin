<?php

namespace App\Traits;

trait flattenRecursive{
    protected $result = [];
    private function convertArrToObj($arr){
    
        foreach ($arr as $key => $value) {
            if ($value['children']) {
                $this->result[] = [
                    "id" => $value['id'],
                    "title" => $value['title'],
                    "id_parent" => intval($value['id_parent']),
                    "url" => $value['url'],
                    "name_route" => $value['name_route'],
                    "icon" => $value['icon'],
                ];
                $this->convertArrToObj($value['children']);
    
            }else {
                # code...
                $this->result[] = [
                    "id" => $value['id'],
                    "title" => $value['title'],
                    "id_parent" => intval($value['id_parent']),
                    "url" => $value['url'],
                    "name_route" => $value['name_route'],
                    "icon" => $value['icon'],
                ];
            } 
        }
    }

    public function flatRecursive($data){
    
        $this->convertArrToObj($data);
        
        return $this->result;
    }
    public function resetFlatRecursive(){
        //reset global variabel
        $this->result=[];
    }
}