<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class employeemodel extends Model
{
    use HasFactory;
  static function showemployee()
  {
  	 $mainData = DB::table('12th_class')
  						 ->select('*')
  						 ->get(); 
  				return $mainData;
  			
  }
}
