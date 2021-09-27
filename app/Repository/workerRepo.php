<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\order_status;
use App\Models\Worker;


class workerRepo
{
    public function checkingParamToAccept($user_id){
        $data = [];
        $data['worker_status_count'] = worker::Where(function($query) use($user_id) { 
            $query->where('user_id',$user_id)->where('status','shapping')->get();})
        ->orWhere(function($query) use($user_id) { 
            $query->where('user_id',$user_id)->where('status','on_my_way')->get();})->count();


            $data['is_he_havea_one_order_at_max'] = order_status::Where(function($query) use($user_id) { 
            $query->where('worker_id',$user_id)->where('status','shapping')->get();
        })
        ->orWhere(function($query) use($user_id) { 
            $query->where('worker_id',$user_id)->where('status','on_my_way')->get();
        })->count();


        return $data;
    }

    public function acceptOrder($order_id,$user_id){
        Order::where('id',$order_id)->where('status','intiate')->update(['worker_id'=>$user_id,'status'=>'start']);
        order_status::where('id',$order_id)->update(['worker_id'=>$user_id,'status'=>'start']);
    }
}