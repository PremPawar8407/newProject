<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classmodel extends Model
{
    use HasFactory;
   protected $table="12th_class";
    public $timestamps=false;

    public function getnameAttribute($value)
    {
    	return ucwords($value);
    }
    public function getaddressAttribute($value)
    {
    	return $value. ", india";
    }
}
