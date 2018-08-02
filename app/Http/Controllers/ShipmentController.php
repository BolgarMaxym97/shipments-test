<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: this is creation new shipment (TEST)
//        $responseSend = (new ApiHelper('shipment', ['id' => 3333, 'name' => 'test3'], 'POST'))->fetch();
        return view('home');
    }

    public function getShipments()
    {
        $response = (new ApiHelper('shipment', [], 'GET'))->fetch();
        return isset($response->data) ? $response->data->shipments : [];
    }

    public function removeShipment(Request $request)
    {
        $id = $request->id;
        $responseSend = (new ApiHelper('shipment/' . $id, [], 'DELETE'))->fetch();
        $success = $responseSend == null ? true : false;
        return response()
            ->json([
                'success' => $success,
                'message' => $success ? 'Successfully deleted' : 'Server Error',
            ]);
    }

    public function sendShipment(Request $request)
    {
        $id = $request->id;
        $responseSend = (new ApiHelper('shipment/' . $id . '/send', [], 'POST'))->fetch();
        $success = $responseSend == null ? true : false;
        return response()
            ->json([
                'success' => $success,
                'message' => $success ? 'Successfully sended' : 'Server Error',
            ]);
    }
}
