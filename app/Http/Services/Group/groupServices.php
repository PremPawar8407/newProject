<?php

namespace App\Http\Services\Group;


use Illuminate\Support\Facades\Request;
use App\Models\groupModel;


class groupServices 
 {

    public function validGrpName($payload)
    {
        return groupModel::validGroupName($payload);
    }

    public function addGroup($payload)
    {
        $criteria['grp_name']       = $payload['grp_name'];
        $criteria['grp_note']       = $payload['grp_note'];
        $criteria['grp_type']       = $payload['grp_type'];
        $criteria['grp_created_by'] = $payload['account_id'];

        return groupModel::addGroup($criteria);

    }

    public function deleteGroup($payload, $usrId)
    {
        $criteria['grp_deleted_by'] = $usrId;
        return groupModel::deleteGroup($criteria);
    }

    
    	
}
?>
