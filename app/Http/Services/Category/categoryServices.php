<?php

namespace App\Http\Services\Category;


use Illuminate\Support\Facades\Request;
use App\Models\categoryModel;


class categoryServices 
 {

    public function addCategory($payload)
    {
        return categoryModel::addCategory($payload);
    }

    public function validateFolderdetail($folderId, $usrId)
    {
        return categoryModel::validateFolderdetail($folderId, $usrId);
    }
    
    public function checkValidName($payload)
    {
        return categoryModel::checkValidName($payload);
    }

    public function checkValidCatID($payload)
    {
        return categoryModel::checkValidCatID($payload);
    }

    public function updateCategory($payload)
    {   
        $criteria['cat_id']          = $payload['cat_id'];
        $criteria['cat_name']        = $payload['cat_name'];
        $criteria['cat_folder_id']   = $payload['folder_id'];
        $criteria['cat_modified_on'] = date(getenv("DATETIME_FORMAT"));
        $criteria['cat_modified_by'] = $payload['account_id'];
        $criteria['cat_state']       = $payload['cat_state'];

        return categoryModel::updateCategoryData($criteria); 
    }

    public function categoryListAll($payload)
    {
        return categoryModel::categoryListAll($payload);
    }
    	
}
?>
