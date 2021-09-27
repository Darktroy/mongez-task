<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_status extends Model
{
    use HasFactory;
    protected $table ='order_statuses';
    protected $fillable = ['order_id', 'worker_id', 'status'];
}
