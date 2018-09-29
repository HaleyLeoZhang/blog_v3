<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AuthViewController extends BaseController
{

    // -
    public function auth_human(Request $request)
    {
        return view('auth.human');
    }

    // -
    public function auth_rule(Request $request)
    {
        return view('auth.rule');
    }

    // -
    public function auth_group(Request $request)
    {
        return view('auth.group');
    }

}
