<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mutatorModel extends Model
{
   // use HasFactory;
	  protected $table="products";
   	public $timestamps=false;
 
    public function setfirstnameAttribute($value)
    { 

    	if (substr(ucfirst($value), 0,3)=="Mr.") 
    	{
    		echo "Mr. is invalid";
    			
    	}else
      {
        $display=$this->attributes['firstname']="Mr.".$value;
        print_r($display);
      }
   	}
    public function setlastnameAttribute($lname)
    {
      $print=$this->attributes['lastname']=$lname. " india";
      print_r($print);
    }
}
