<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\Worker;
use Faker\Factory as Faker;
use Faker\Factory;

class users_worker_order extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        $faker = Faker::create();
        for ($i=0; $i < 1000 ; $i++) { 

            $user = new User();
            $user->name = ($i % 3 == 0 )? 'admin-'.$i:'mongezworker-'.$i;
            $user->email =  ($i % 3 == 0 )? 'admin'.$i.'@mongaz.com':'mongezworker'.$i.'@mongaz.com';
            $user->password =Hash::make('password');
            $user->is_worker = ($i % 3 == 0 )? false : true;
            $user->email_verified_at = '2021-09-24 16:12:52.000000';
            $user->save();
            if($i % 3 != 0){
                $worker = new Worker();
                $worker->user_id = $user->id;
                $worker->status =($i % 3 == 1 )? 'shapping':'on_my_way' ;
                $worker->latitude = 29.88501541157709; 
                $worker->longitude = 30.915834195956933;
                $worker->save();

                $order = new Order();
                $order->user_id = $user->id;
                $order->latitude = 29.88501541157709; 
                $order->longitude = 30.915834195956933;
                $order->description = $faker->paragraph;
                $order->save();
            }

        }

    }
}
// 7 % 2 = 1    // the remainder
