<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class downloadUsr extends Model
{
    use HasFactory;
  	public static function usrDownloadFile($subscription, $sortBY, $order)
	  {
	  		$usrData = DB::table('sign_up')
	  					->select('*')
	  					->where('subscription', $subscription)
	  					->orderBy($sortBY, $order)
	  					->get();
	  		return $usrData;
	  }
}
