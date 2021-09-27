<?php
namespace App\Http\Controllers;

use App\Http\Requests\acceptOrderRequest;
use App\Http\Requests\acceptSpecificOrderRequest;
use App\Http\Requests\initiateOrderRequest;
use App\Models\Order;
use App\Models\order_status;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Repository\workerRepo;
use Illuminate\Support\Facades\Auth;

class OrderAndWorkerController extends Controller
{
    
    public function allWorkerNear(acceptOrderRequest $request){
        $worker = new Worker();
        $data = $worker->getNears($request);
        return response()->json(['data'=>$data,200]);
    }

    public function makeOrder(initiateOrderRequest $request){
        $data = Order::addOrder($request);
        return response()->json(['message'=>$data],200);
    }

    public function sendOrder(){
        $order = new Order();
        $order->sendOrder();
    }

    public function workerAcceptRefuseOrder(acceptSpecificOrderRequest $request){
        $repo_obj = new workerRepo();
        $connditons = $repo_obj->checkingParamToAccept(Auth::user()->id);
        if($connditons['worker_status_count'] >0 && $connditons['is_he_havea_one_order_at_max'] < 2){
            $repo_obj->acceptOrder($request->order_id,Auth::user()->id);
        }else{
            return response()->json(['error'=>'This worker can not accept',200]);
        }

    }
}