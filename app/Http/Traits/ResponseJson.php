<?php


namespace App\Http\Traits;


trait ResponseJson
{
    public static function response($data = [], $status = 200, $message = 'success')
    {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data], $status);
    }
}
