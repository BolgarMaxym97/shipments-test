<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AuthCustomController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validation($request);
        $data = $request->post();
        // Because API throws error on additional elements in array
        unset($data['_token']);
        $response = (new ApiHelper('login', $data, 'POST'))->fetch();
        $token = isset($response->data) ? $response->data[0]->token : false;
        \Session::put('auth_token', $token);
        if (!$token) {
            \Session::flash('error', 'Wrong email or password');
            return redirect(route('login'));
        }
        return redirect(route('home'));
    }

    public function logout(Request $request)
    {
        \Session::remove('auth_token');
        return redirect(route('login'));
    }

    private function validation($request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);
    }
}
