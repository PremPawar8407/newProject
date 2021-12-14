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

   public static function deleteGroup($value, $criteria)
   {
   	  $addGroupData = DB::table('tbl_group')
   	  				->where('grp_id', $value['grp_id'])
   	  				->update($criteria);
   	  return $addGroupData;
   }


   public static function updateGrp($value)
   {
      $updateGrpData = DB::table('tbl_group')
                      ->where('grp_id', $value['grp_id'])
                      ->update($value);
      return $updateGrpData;
   }

   public static function fetchAllGroup($value)
   {
      

      $grpAllData = DB::table('tbl_group')
                  ->select('grp_id', 'grp_name', 'grp_note', 'grp_created_on')
                  ->where('grp_created_by', $value['account_id'])
                  ->where('grp_type', $value['grp_type'])
                  ->orderBy($value['sort_by'], $value['order'])
                  ->offset($value['offset'])
                  ->limit($value['num'])
                  ->get();

      $newGrpData = array();

               foreach ($grpAllData as $grpData) 
               {
                  $grpData->cnt_subscribers = 10;
                  array_push($newGrpData, $grpData);
               }
               return $newGrpData;
   }

   public static function fetchDataGroupId($value)
   {
     
      $fetchGrpIdData = DB::table('tbl_group')
                  ->select('grp_id', 'grp_name', 'grp_note')
                  ->where(array('grp_created_by' => $value['account_id'], 'grp_id' => $value['grp_id']))
                  ->get();

      return $fetchGrpIdData;
   }
}
