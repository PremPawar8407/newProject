<?php

namespace App\Http\Services\MongoDB;

use App\Models\CheckMongoModel;
use Illuminate\Support\Facades\Request; 
//use Illuminate\Http\Request;


class mongoServices 
{

    function crateRegistration($payload)
    {
        $addData = CheckMongoModel::crateRegistration($payload);
        return $addData;
    }

    function readData()
    {
    	return CheckMongoModel::readData();
    }

    function validMongoId($folderId)
    {
    	return CheckMongoModel::validMongoId($folderId);
    }

    function updateData($payload)
    {
    	return CheckMongoModel::updateData($payload);
    }

    function deleteData($mongoID)
    {
    	return CheckMongoModel::deleteData($mongoID);
    }
}
?>
