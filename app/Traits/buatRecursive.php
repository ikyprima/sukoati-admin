<?php

namespace App\Traits;

trait buatRecursive{
    
    private function buildTree(&$elements, $parentId = 0) {
    
        $branch = collect();
        foreach ($elements as $element) {
            if ($element['id_parent'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch->push($element);
            
            }
        }
        return $branch;
    }

    public function ubahRecursive($data){
    
        return $this->buildTree($data);
    }

}