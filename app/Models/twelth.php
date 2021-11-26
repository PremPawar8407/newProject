<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class twelth extends Model
{
   // use HasFactory;
   protected $table="12th_class";
    public $timestamps=false;

  public function setnameAttribute($name)
  {
  	if (substr(ucfirst($name), 0,3)=="Mr.") 
  	{
  		echo "Mr. is invalid";
      die();
  		
  	}
    else
    {
  	$insert=$this->attributes['name']="Mr.".$name;
    }

  }
  public function setaddressAttribute($value)
  {
    $checkvalue=ucwords($value);
     $str_start=strrpos($checkvalue,"Maharashtra");
    $str_length=strlen($checkvalue);
    $lastword=substr($checkvalue, $str_start,$str_length);
    if (trim($lastword)=="Maharashtra") 
    {
    echo "Maharashtra is invalid";
    die();
    }
    else
    {
    $address=$this->attributes['address']=$value. " Maharashtra";
    }
  }
}
