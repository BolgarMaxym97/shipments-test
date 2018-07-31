<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthCustomController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->post();
        // Because API throws error on additional elements in array
        unset($data['_token']);
        // TODO: add validation
        $response = (new ApiHelper('login', $data, 'POST'))->fetch();
        // TODO: set token
        \Session::put('auth_token', true);
        return redirect(route('home'));
    }

    public function logout(Request $request)
    {
        \Session::remove('auth_token');
        return redirect(route('login'));
    }
}
