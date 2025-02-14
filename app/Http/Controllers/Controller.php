<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\TransactionHistory;
use App\Models\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successMessage($msg){
        return response()->json(['status' => 200, 'msg' => $msg]);
    }

    public function errorMessage($msg){
        return response()->json(['status' => 500, 'msg' => $msg]);
    }

    public function validationErrorMessage($msg){
        return response()->json(['status' => 403, 'msg' => $msg]);
    }

    public function successDataMessage($msg, $data){
        return response()->json(['status' => 200, 'msg' => $msg, 'data' => $data]);
    }
}
