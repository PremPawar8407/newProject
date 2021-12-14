<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class contact extends Model
{
    use HasFactory;
   
   public static function addContact($value)
   {
   	 $lastContactId = DB::table('tbl_contact')->insertGetId($value);
   	 return $lastContactId;
   }

   public static function checkPhoneNumber($value)
   {
   	$phoneNmuber = DB::table('tbl_contact')
   					->select('con_phone_number')
   					->where('con_phone_number', $value['phone_number'])
   					->where('con_account_id', $value['account_id'])
   					->get();
   	return $phoneNmuber;
   }

   public static function addRelContactGrp($value)
   {
   		$relcontactGrpId = DB::table('tbl_rel_contact_group')->insertGetId($value);
   	 	return $relcontactGrpId;
   }

   public static function updateContact($conID, $value)
   {
   		$updateContact = DB::table('tbl_contact')
   						 ->where('con_id', $conID)
   						 ->update($value);
   	 	return $updateContact;
   }

   public static function listAllContact($value)
   {
   		 $where = array('con_account_id' => $value['account_id']);
   		 if (array_key_exists('grp_id', $value)) {
   		 	$where['grp_id'] = $value['grp_id'];
   		 }
            $whereRaw = "con_deleted_by = 0 ";
            if(array_key_exists("number", $value)){
                $whereRaw .= " AND con_phone_number like '%" . $value['number'] . "%'";
            }

           if (array_key_exists("area_code", $value))
          		$whereRaw .= "AND con_phone_number like '" . $value['area_code'] . "%'";	

          	if (array_key_exists("name", $value)) {
          		$whereRaw .= " AND CONCAT(con_first_name, ' ' , con_last_name) LIKE '%" . $value['name'] . "%'";
          	}

          	if(array_key_exists("con_type", $value))
                       $whereRaw .= ($value['con_type'] == "PRIVATE") ?  " AND con_is_public = 0 " : " AND con_is_public = 1 ";

   		 $contactList = DB::table('tbl_contact')
   					->select('tbl_contact.con_id', 'con_phone_number', 'con_first_name', 'con_last_name', 'con_email', 'con_status', 'con_created_on')
   					->leftJoin('tbl_rel_contact_group', 'tbl_contact.con_id', '=', 'tbl_rel_contact_group.con_id')
   					->where($where)
   					->whereRaw($whereRaw)
   					->limit($value['num'])
   					->offset($value['offset'])
   					->orderBy($value['sort_by'], $value['order'])
   					->get();
   			return $contactList;
   			


   }
}
