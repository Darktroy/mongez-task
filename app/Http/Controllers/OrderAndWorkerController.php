<?php

namespace App\Http\Controllers;

use App\Http\Requests\acceptOrderRequest;
use Illuminate\Http\Request;
use App\Models\Worker;

class OrderAndWorkerController extends Controller
{
    public function allWorkerNear(acceptOrderRequest $request){
        $worker = new Worker();
        $data = $worker->getNears($request);
        return response()->json(['data'=>$data,200]);
    }
}