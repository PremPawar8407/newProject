<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accessormodel extends Model
{
    use HasFactory;
   protected $table="products";
    
    function getfirstnameAttribute($data)
    {
    	return ucFirst($data);
    }
    function getlastnameAttribute($data)
    {
    	return $data."(diffrentiate)";
    }
}
