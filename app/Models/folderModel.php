<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use DB;

class folderModel extends Model
{
    use HasFactory;
   public static function addFolder($value, $usrId)
   {
   	$insertData = [
   					"folder_name"       => $value['folder_name'],
   					"folder_password"   => $value['folder_password'],
   					"folder_state"      => $value['folder_state'],
   					"folder_type"       => $value['folder_type'],
   					"folder_created_by" => $usrId
   					];


   	$addData = DB::table('usr_folder')->insertGetId($insertData);
   	return $addData;



   }

   public static function validateFolderName($value, $usrId)
   {
   	$addData = DB::table('usr_folder')
   					->select('*')
   					->where('folder_name', $value)
   					->where('folder_created_by', $usrId)
   					->get();
   	return $addData;

   	 
   }

   public static function folderDatausingUsrId($value, $usrId)
   {
   	$fetchData = DB::table('usr_folder')
   					->select('id', 'folder_name')
   					->where('folder_created_by', $usrId)
   					->where('folder_state', $value['folder_state'])
   					->where('folder_type', $value['folder_type'])
   					->orderBy('folder_name', 'ASC')
   					->get();
   	return $fetchData;
   	log::info('folder fetch using user-'.$usrId. 'successfull');
   }

   public static function folderFetchUsingType($value)
	{
   	  $fetchData = DB::table('usr_folder')
   	  			   ->select('*')
   	  			   ->where('folder_created_by', $value['usr_id'])
   	  			   ->where('folder_type', $value['folder_type'])
   	  			   ->orderBy('folder_name', 'ASC')
   	  			   ->get();
   	  return $fetchData;
   }

   public static function updateData($folderId, $value)
   {
   		$updateData = DB::table('usr_folder')
   					 ->select('*')
   					 ->where('id', $folderId)
   					 ->update($value);
   		return $updateData;
   }
}
