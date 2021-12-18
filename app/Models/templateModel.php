<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Log;

class templateModel extends Model
{
    use HasFactory;

    public static function validCatID($criteria)
    {
    	$catIdData = DB::table('category')
    				->select('*')
    				->where('cat_id', $criteria['cat_id'])
    				->where('cat_created_by', $criteria['account_id'])
    				->get();

    	return $catIdData;
    }

    public static function validTmplName($criteria)
    {
    	$catIdData = DB::table('usr_template')
    				->select('tmpl_name')
    				->where('tmpl_name', $criteria['tmpl_name'])
    				->where('tmpl_created_by', $criteria['account_id'])
    				->get();

    	return $catIdData;
    }

    public static function addMedia($criteria)
    {
    	$lastInsertedID = DB::table('usr_media')
    					->insertGetId($criteria);
    			return $lastInsertedID;
    }

    public static function addTemplate($criteria)
    {

    	if (array_key_exists("tmpl_media_id", $criteria)) 
    	{
    		$criteria['media_id'];
    	} else
    	{
    		$criteria['media_id'] = 0;
    	}
		$insertData =   [
							"tmpl_folder_id" => $criteria['folder_id'],
							"tmpl_cat_id" => $criteria['cat_id'],
							"tmpl_name" => $criteria['tmpl_name'],
							"tmpl_message" => $criteria['tmpl_message'],
							"tmpl_media_id" => $criteria['media_id'],
							"tmpl_created_on" => date(getenv("DATETIME_FORMAT")),
							"tmpl_created_by" => $criteria['account_id'],
							"tmpl_type" => $criteria['tmpl_type']
						];

		$lastInsertedID = DB::table('usr_template')->insertGetId($insertData);
        Log::info("Template inseted successfull [" . $criteria['account_id'] . ": " . $lastInsertedID ."]");
		return $lastInsertedID;
    }

    public static function showTmplData($lastTmplID)
    {
    	$getTmplData = DB::table('usr_template')
    				->select('tmpl_id', 'tmpl_type', 'tmpl_created_by')
    				->where('tmpl_id', $lastTmplID)
    				->get();
    	return $getTmplData;
    }

    public static function addDripMsg($criteria)
    {
    	$insertDripMsg = DB::table('user_drip_messages')->insert($criteria); 
        Log::info("Dipmsg inseted successfull [" . $criteria['account_id'] . ": " . $insertDripMsg ."]");  				
    	return $insertDripMsg;
    }

    public static function checkValidTmplId($tmplID, $usrId)
    {
        $tmplData = DB::table('usr_template')
                    ->select('*')
                    ->where('tmpl_id', $tmplID)
                    ->where('tmpl_created_by', $usrId)
                    ->get();
        return $tmplData;
    }

    public static function updateTemplate($criteria)
    {
        $updateTmpl = DB::table('usr_template')
                    ->select('*')
                    ->where('tmpl_id', $criteria['tmpl_id'])
                    ->update($criteria);

        return $updateTmpl;
    }

    public static function templateListAll($criteria)
    {
       $where = array(array("tmpl_created_by", '=', $criteria['account_id']), array("tmpl_type", "=", $criteria['tmpl_type']));

             if(array_key_exists("folder_id", $criteria))
                array_push($where, array("tmpl_folder_id", '=', $criteria['folder_id']));
            
             if(array_key_exists("cat_id", $criteria))
                 array_push($where, array("tmpl_cat_id", '=', $criteria['cat_id']));

             $templateList = DB::table('usr_template')
                    ->select('tmpl_id', 'media_url', 'tmpl_name', 'tmpl_message', 'tmpl_type')
                    ->leftJoin('usr_media', 'usr_template.tmpl_media_id', '=', 'usr_media.media_id')
                    ->where($where)
                    ->where('tmpl_deleted_by', null)
                    ->get();
            return $templateList;

    }

    public static function templateListAllUsrId($payload)
    {
        $where = array(array('tmpl_type', $payload['tmpl_type']), array('tmpl_created_by', $payload['account_id']));
        
           if(array_key_exists("folder_id", $payload))
                array_push($where, array("tmpl_folder_id", $payload['folder_id']));
            
             if(array_key_exists("cat_id", $payload))
                 array_push($where, array("tmpl_cat_id", $payload['cat_id']));

        $templateListUsr = DB::table('usr_template')
                    ->select('tmpl_id', 'folder_name', 'cat_name', 'media_url', 'tmpl_name', 'tmpl_message', 'tmpl_type')
                    ->join('usr_folder', 'usr_template.tmpl_folder_id', '=', 'usr_folder.id')
                    ->join('category', 'usr_template.tmpl_cat_id' , '=', 'category.cat_id')
                    ->leftJoin('usr_media', 'usr_template.tmpl_media_id', '=', 'usr_media.media_id')
                    ->where($where)
                    ->get();
        return $templateListUsr;
    }

    public static function dripMsgList($payload)
    {
        $dripMsgList = DB::table('user_drip_messages')
                    ->select('drp_id', 'drp_tmpl_id', 'drp_type', 'drp_days', 'drp_hours', 'drp_minutes', 'drp_meridiem', 'drp_message', 'drp_media_id', 'drp_created_on', 'tmpl_name', 'media_url', 'tmpl_type')
                    ->join('usr_template', 'user_drip_messages.drp_tmpl_id', '=', 'usr_template.tmpl_id')
                    ->leftJoin('usr_media', 'usr_template.tmpl_media_id', '=', 'usr_media.media_id')
                    ->where(array('drp_tmpl_id' => $payload['tmpl_id']))
                    ->get();
        
        return $dripMsgList;  
    }


    public static function fetchTemplateDetails($tmplID)
    {
         
             $groupData = DB::table('usr_template')
                    ->select('tmpl_id', 'tmpl_folder_id', 'tmpl_cat_id', 'folder_name', 'cat_name', 'media_id', 'media_url','tmpl_name','tmpl_message','tmpl_type')
                    ->join('usr_folder', 'usr_template.tmpl_folder_id', '=', 'usr_folder.id')
                    ->join('category', 'usr_template.tmpl_cat_id' , '=', 'category.cat_id')
                    ->leftJoin('usr_media', 'usr_template.tmpl_media_id', '=', 'usr_media.media_id')
                    //->where('tmpl_deleted_by', null)
                    ->where('tmpl_id', $tmplID)
                    ->get();

            return $groupData;
    }

    public static function templateDelete($tmplID, $criteria)
    {
        $deleteTmpl = DB::table('usr_template')
                    ->select('*')
                    ->where('tmpl_id', $tmplID)
                    ->update($criteria);

        return $deleteTmpl;
    }


    public static function updateDripMessages($drpID, $criteria)
    {  
        $updateDrpMsg = DB::table('user_drip_messages')
                    ->where('drp_id', $drpID)
                    ->update($criteria);

        return $updateDrpMsg;
    }

    public static function deleteDripMessages($payload)
    {
        $criteria['drp_deleted_on'] = date(getenv('DATETIME_FORMAT'));
        $criteria['drp_deleted_by'] = $payload['account_id'];

        $deletedrpMsg = DB::table('user_drip_messages')
                    ->where('drp_id', $payload['drp_id'])
                    ->update($criteria);

        return $deletedrpMsg;
    }

}
