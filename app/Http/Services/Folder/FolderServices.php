<?php

namespace App\Http\Services\Folder;

use App\Models\signUp;
use Illuminate\Support\Facades\Request;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\folderModel;
//use Illuminate\Http\Request;


class FolderServices 
 
    {

    public  function addFolder($payload, $usrId) 
    {
        return folderModel::addFolder($payload, $usrId);
      }

    public  function validateFolderName($payload, $usrId) 
    {
        return folderModel::validateFolderName($payload, $usrId);
      }

    public function  showFolderData($payload, $usrId)
    {
        $fetchFolderData = folderModel::folderDatausingUsrId($payload, $usrId);
        return $fetchFolderData;
    }
    public function folderTypeFetch($payload)
    {
        return folderModel::folderFetchUsingType($payload);
    }

    public function updateFolder($payload, $usrId)
    {
        if (array_key_exists('folder_name', $payload)) 
        {
            $updateData['folder_name'] = $payload['folder_name'];
        }
        if (array_key_exists('folder_password', $payload)) 
        {
            $updateData['folder_password'] = $payload['folder_password'];
        }
        if (array_key_exists('folder_state', $payload)) 
        {
            $updateData['folder_state'] = $payload['folder_state'];
        }
        if (array_key_exists('folder_type', $payload)) 
        {
            $updateData['folder_type'] = $payload['folder_type'];
        }
        $updateData['folder_modified_by'] = $usrId;
    
        return folderModel::updateData($payload['folder_id'], $updateData);
    }


    
    	
}
?>
