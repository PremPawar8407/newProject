<?php

namespace App\Http\Services\Contact;


use Illuminate\Support\Facades\Request;
use App\Models\contact;


class contactServices 
 {

    public function addContact($payload)
    {
        $criteria['con_status'] = 0;
        $criteria['con_phone_number'] = $payload['phone_number'];
        $criteria['con_first_name']   = $payload['first_name'];
        $criteria['con_last_name']    = $payload['last_name'];
        $criteria['con_email']        = $payload['email'];
        $criteria['con_account_id']   = $payload['account_id'];
        $criteria['con_created_on']   = date(getenv("DATETIME_FORMAT"));
        $criteria['con_add_source']   = 'INDIVIDUAL';
        $criteria['con_notes']        = $payload['notes'];
        return contact::addContact($criteria);
    }

    public function checkPhoneNumber($payload)
    {
        return contact::checkPhoneNumber($payload);
    }

    public function addRelContactGrp($contactID, $payload)
    {
       $criteria['con_id']     = $contactID;
       $criteria['grp_id']     = $payload['con_group_id'];
       $criteria['created_on'] = date(getenv("DATETIME_FORMAT"));
       $criteria['created_by'] = $payload['account_id'];

       return contact::addRelContactGrp($criteria);
    }

    public function updateContact($payload)
    {
        $criteria['con_first_name']   = $payload['first_name'];
        $criteria['con_last_name']    = $payload['last_name'];
        $criteria['con_email']        = $payload['email'];
        $criteria['con_modified_on']  = date(getenv("DATETIME_FORMAT"));
        $criteria['con_modified_by']  = $payload['account_id'];
        $criteria['con_notes']        = $payload['notes'];

        return contact::updateContact($payload['con_id'], $criteria);

    }

    public function listAllContact($payload)
    {
       return contact::listAllContact($payload);
    }
    
    	
}
?>
