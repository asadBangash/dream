<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Enums\ApiStatus;
trait ApiReturnFormatTrait
{

    protected function responseWithSuccess($message = '', $data = [], $code = ApiStatus::SUCCESS)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function responseWithError($message = '', $data = [], $code = ApiStatus::ERROR)
    {
        if ($code == null) {
            $code = 400;
        }
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}