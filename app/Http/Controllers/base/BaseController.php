<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function success($data, $message = 'success', $status_code = 200) {
        return response()->json([
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($data, $message = 'error', $status_code = 400) {
        return response()->json([
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ]);
    }

}
