<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class groupModel extends Model
{
    use HasFactory;
   public static function validGroupName($value)
   {
   	//return $value;
   	//exit();
   		$grpNameData = DB::table('tbl_group')
   					->select('grp_name')
   					->where('grp_name', $value['grp_name'])
   					->where('grp_created_by', $value['account_id'])
   					->get();
   	return $grpNameData;
   }


   public static function addGroup($value)
   {
   	  $addGroupData = DB::table('tbl_group')->insertGetId($value);
   	  return $addGroupData;
   }

   public static function deleteGroup($value)
   {
   	return $value;
   	exit();
   	  $addGroupData = DB::table('tbl_group')
   	  				->where('grp_id', $value['grp_id'])
   	  				->update()
   	  return $addGroupData;
   }
}
