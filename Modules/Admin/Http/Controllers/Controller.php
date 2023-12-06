<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController ;


class Controller extends BaseController
{
    public function getSlug(Request $request){
        // if (isset($this->slug)) {
        //     $slug = $this->slug;
        // } else {
        //     $slug = explode('.', $request->route()->getName())[0];
        // }

        // return $slug;
        if ($request->route() && $request->route()->getName()) {
            $slug = explode('.', $request->route()->getName())[0];
        } else {
            // Default jika route atau getName() null
            $slug = 'default';  // Gantilah dengan nilai default yang sesuai
        }
    
        return $slug;
    }
}
