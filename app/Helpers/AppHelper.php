<?php
namespace App\Helpers;

class AppHelper
{
    static public function isAdmin($request, $faq) {
        return $request->admin_code == $faq->admin_code; // TODO is safe ?
    }

    static public function checkAdminCode($request, $faq){
        if(!AppHelper::isAdmin($request, $faq)) {
            abort(403, 'Unauthorized action.');
        }
    }
}

