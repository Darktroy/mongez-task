<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $table ='workers';
    protected $fillable = [
        'user_id',
        'worker_id',
        'latitude',
        'longitude',
        'status'
    ];

    public function getNears($data){
        $quey ='select *, ST_Distance_Sphere( point ('.$data->longitude.', '.$data->latitude.'), 
                point(longitude, latitude)) * .001  as `distance_in_kms` from `workers`
                having `distance_in_kms` <= 5 order by `distance_in_kms` asc';
        
                
/*
https://stackoverflow.com/questions/2234204/find-nearest-latitude-longitude-with-an-sql-query

The original answers to the question are good, but newer versions of mysql (MySQL 5.7.6 on) support geo queries, so you can now use built in functionality rather than doing complex queries.

You can now do something like:

select *, ST_Distance_Sphere( point ('input_longitude', 'input_latitude'), 
                              point(longitude, latitude)) * .001 
          as `distance_in_kms` 
  from `TableName`
having `distance_in_kms` <= 'input_max_distance'
 order by `distance_in_kms` asc

The results are returned in meters. 
So if you want in KM simply use .001 instead of .000621371192 (which is for miles).
So if you want in Miles simply use .000621371192 instead of .001 (which is for km).

*/
    }
}
