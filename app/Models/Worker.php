<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Worker extends Model
{
    use HasFactory;

    protected $table ='workers';
    protected $fillable = ['user_id', 'worker_id', 'latitude', 'longitude', 'status'];

    public function getNears($data){
        // dd(DB::select('SHOW VARIABLES LIKE "%ST_DISTANCE_SPHERE%"'));


        $quey ='select *, ST_Distance_Sphere( point ('.$data->longitude.', '.$data->latitude.'), 
                point(longitude, latitude)) * .001  as `distance_in_kms` from `workers`
                having `distance_in_kms` <= 5 order by `distance_in_kms` asc';

                $quey ='SELECT *,(6371 *
                                acos(cos(radians('.$data->latitude.')) *  cos(radians(latitude)) *cos(radians(longitude) - radians('.$data->longitude.')) + 
   sin(radians('.$data->latitude.')) * sin(radians(latitude)))) AS distance 
    FROM workers  HAVING distance < 5  ORDER BY distance ';
        return DB::select($quey);
    }
    public static function getNearsStatic($data){
        // dd(DB::select('SHOW VARIABLES LIKE "%ST_DISTANCE_SPHERE%"'));


        $quey ='select *, ST_Distance_Sphere( point ('.$data->longitude.', '.$data->latitude.'), 
                point(longitude, latitude)) * .001  as `distance_in_kms` from `workers`
                having `distance_in_kms` <= 5 order by `distance_in_kms` asc';

                $quey ='SELECT *,(6371 *
                                acos(cos(radians('.$data->latitude.')) *  cos(radians(latitude)) *cos(radians(longitude) - radians('.$data->longitude.')) + 
   sin(radians('.$data->latitude.')) * sin(radians(latitude)))) AS distance 
    FROM workers  HAVING distance < 5  ORDER BY distance ';
        return DB::select($quey);
    }
}
