<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createItem(Request $request)
    {
        $responseSend = (new ApiHelper('item', $request->post(), 'POST'))->fetch();
        $success = isset($responseSend->data);
        return response()
            ->json([
                'success' => $success,
                'item' => $success ? $responseSend->data : [],
                'message' => $success ? 'Successfully created' : 'Server Error',
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editItem(Request $request)
    {
        $data = [
            'id' => $request->item['id'],
            'name' => $request->item['name'],
            'shipment_id ' => $request->item['shipment_id'],
            'code' => $request->item['code'],
        ];
        $responseSend = (new ApiHelper('item/' . $data['id'], $data, 'PUT'))->fetch();
        $success = isset($responseSend->data);
        return response()
            ->json([
                'success' => $success,
                'message' => $success ? 'Successfully renamed' : 'Server Error',
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItem(Request $request)
    {
        $id = $request->id;
        $responseSend = (new ApiHelper('item/' . $id, [], 'DELETE'))->fetch();
        $success = $responseSend == null ? true : false;
        return response()
            ->json([
                'success' => $success,
                'message' => $success ? 'Successfully deleted' : 'Server Error',
            ]);
    }
}
