<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function response($result = "", $message = 'Action performed successfully', $status = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'status' => $status == 200 ? 'success' : 'error',
            'message' => $message,
            'result'    => $result,
        ];

        return response()->json($response, $status);
    }
}
