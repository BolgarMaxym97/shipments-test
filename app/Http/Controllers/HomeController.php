<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userToken =  \Session::get('auth_token');
        $response = (new ApiHelper('shipment', [], 'GET'))->fetch();
        // TODO: this is creation new shipment (TEST)
//        $responseSend = (new ApiHelper('shipment', ['id' => 211314, 'name' => 'test2'], 'POST'))->fetch();
        dd($response);
        return view('home');
    }
}
