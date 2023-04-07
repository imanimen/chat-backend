<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    /**
     * @param array $data
     */
    public function successResponse(array $data = [], $code = 200)
    {
        return $this->whiteHouse($data, $code);
    }

    /**
     * @param array $data
     */
    public function failResponse(array $data = [], $code = 500)
    {
        return $this->whiteHouse(count($data) ? $data : ['status' => 'fail'], $code);
    }

    public function whiteHouse(array $data = [], int $code = 200)
    {
        return response()->make([
            'data' => $data,
            'errors' => [],
            'messages' => [],
            'code' => $code,
        ])->setStatusCode($code);

    }
    public function validateRequest(Request $request, array $rules, array $messages = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return $this->whiteHouse([
                'data' => [],
                'errors' => $validator->errors()->all(),
                'messages' => $validator->messages(),
                'code' => 200,
            ]);
        }
    }
    
}

