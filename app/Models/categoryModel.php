<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class categoryModel extends Model
{
    use HasFactory;

   public static function addCategory($value)
   {

   		$criteria['cat_folder_id']  = $value['folder_id'];
   		$criteria['cat_name']       = $value['cat_name'];
   		$criteria['cat_type']       = $value['folder_type'];
   		$criteria['cat_created_on'] = date(getenv("DATETIME_FORMAT"));
   		$criteria['cat_created_by'] = $value['account_id'];

   		$insertCategoryId = DB::table('category')->insertGetId($criteria);

   		return $insertCategoryId;
	}

	public static function validateFolderdetail($folderId, $usrID)
	{
		$validFolderData = DB::table('usr_folder')
							->select('folder_name', 'folder_type')
							->where('id', $folderId)
							->where('folder_created_by', $usrID)
							->get();

		 return $validFolderData;
	}

	public static function checkValidName($payload)
	{
		$validFolderData = DB::table('category')
							->select('cat_name')
							->where('cat_name', $payload['cat_name'])
							->where('cat_created_by', $payload['account_id'])
							->get();
		return $validFolderData;
	}

	public static function checkValidCatID($payload)
	{
		$validCategorID = DB::table('category')
							->select('cat_id')
							->where('cat_id', $payload['cat_id'])
							->where('cat_created_by', $payload['account_id'])
							->get();
		return $validCategorID;
	}

	public static function updateCategoryData($criteria)
	{
		$updateCategory = DB::table('category')
							->where('cat_id', $criteria['cat_id'])
							->update($criteria);
		return $updateCategory;
	}

	public static function categoryListAll($value)
	{
		$fetchCategoryList = DB::table('category')
								->select('cat_id', 'cat_name', 'folder_name', 'cat_folder_id', 'cat_created_on', 'cat_type', 'cat_state')
								->leftJoin('usr_folder', 'category.cat_folder_id', '=', 'usr_folder.id')
								->where('cat_folder_id', $value['folder_id'])
								->where('cat_created_by', $value['account_id'])
								->get();
		return $fetchCategoryList;
	}

}
