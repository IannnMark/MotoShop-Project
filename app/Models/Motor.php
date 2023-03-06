<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'motor_img', 'customer_id'];

    public function customer(){
       return $this->belongsTo('App\Models\Customer'); 
        }
}
