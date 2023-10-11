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
                    "is_parent"=> intval($value["is_parent"]),
                    "id_parent" => intval($value['id_parent']),
                    "id_menu" => $value['id_menu'],
                    'permission' => $value['permission']->pluck('id_permissions'),
                    'role' => $value['role']->pluck('id_roles'),
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
                    "is_parent"=> intval($value["is_parent"]),
                    "id_parent" => intval($value['id_parent']),
                    "id_menu" => $value['id_menu'],
                    'permission' => $value['permission']->pluck('id_permissions'),
                    'role' => $value['role']->pluck('id_roles'),
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