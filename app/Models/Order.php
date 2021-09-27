<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $table ='orders';
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'description',
        'status',
    ];

    public static function addOrder($data){
        $order = new self();
        $order->user_id = Auth::user()->id;
        
        $order->latitude = $data->latitude;
        $order->longitude = $data->longitude;
        $order->description = $data->description;
        $order->status = 'intiate';
        $order->save();
        $response = self::sendFirstOrderRequest($data,$order);
        if($response){
            return 'order saved and send for first worker';
        }else{
            return 'order saved but there is no available worker ';
        }
    }

    public function sendOrder(){
        $intiated_orders = self::where('status','intiate')->get()->all();
        dd($intiated_orders);
        foreach ($intiated_orders as $key => $value) {
            // array:9 [
            //     "id" => 668
            //     "latitude" => 29.925
            //     "longitude" => 30.938839999999
            //     "status" => "intiate"
            //     "description" => "ask me if you dare"
            //     "user_id" => 4
            //     "worker_id" => null
            //     "created_at" => "2021-09-27 02:23:52"
            //     "updated_at" => "2021-09-27 02:23:52"
            //   ]
            //   #original: array:9 [
            //     "id" => 668
            //     "latitude" => 29.925
            //     "longitude" => 30.938839999999
            //     "status" => "intiate"
            //     "description" => "ask me if you dare"
            //     "user_id" => 4
            //     "worker_id" => null
            //     "created_at" => "2021-09-27 02:23:52"
            //     "updated_at" => "2021-09-27 02:23:52"
        }
    }

    private static function sendFirstOrderRequest($data,$order){
        $worker = new Worker();
        $data = $worker->getNears($data);
        $sent = false;
        // order_status::where('order_id',$order->id)->where('status','intiate')->update(['status'=>'non-taked']);
        
        // $order_status_worker = order_status::select('worker_id')->where('order_id',$order->id)->get()->toArray();
        // dd($order_status_worker);
        foreach ($data as $key => $value) {
            if( in_array($value->status, ['shapping', 'on_my_way','free'])){
              order_status::create(['order_id'=>$order->id, 'worker_id'=>$value->user_id, 'status'=>'intiate']);
              //send notification
              return true;
            }
        }
        return false;
    }//end of sendFirstOrderRequest



    private static function sendRepeatableOrderRequest($data,$order){
        $worker = new Worker();
        $data = $worker->getNears($data);
        $sent = false;
        order_status::where('order_id',$order->id)->where('status','intiate')->update(['status'=>'non-taked']);
        
        // $order_status_worker = order_status::select('worker_id')->where('order_id',$order->id)->get()->toArray();
        // dd($order_status_worker);
        foreach ($data as $key => $value) {
            if( in_array($value->status, ['shapping', 'on_my_way','free'])){
              order_status::create(['order_id'=>$order->id, 'worker_id'=>$value->user_id, 'status'=>'intiate']);
              //send notification
              return true;
            }
        }
        return false;
    }//end of sendFirstOrderRequest

}
