<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MongoDB\Client as Mongo;

class CheckMongoModel extends Model
{
    use HasFactory;
   public static function crateRegistration($payload)
   {
   		$mongo  =  new Mongo;
		$dbName = 'project';
		$collection_name = 'newdata';
		$connection = $mongo->$dbName->$collection_name;

		$firstname = (String) $payload['firstname'];
		$lastname  = (String) $payload['lastname'];
		$phone     = (String) $payload['Phone'];

		//return $connection->find()->toArray();
		//exit();
		
		$insrtData = $connection->insertOne([
						"firstname" => $firstname,
						"lastname"  => $lastname,
						"phone"     => $phone
					  ]);

		return $insrtData->getInsertedId();
	
	}

	public static function readData()
	{
		$mongo 			 = new Mongo;
		$dbName 		 = "project";
		$collection_name = "newdata";
		$connection      = $mongo->$dbName->$collection_name;
		$document        = $connection->find()->toArray();

		return $document;
	}


	public static function validMongoId($folderId)
	{

		try 
		{
			$mongo 			 = new Mongo;
			$dbName 		 = "project";
			$collection_name = "newdata";
			$connection      = $mongo->$dbName->$collection_name;
			$document        = $connection->find(['_id'  => new \MongoDB\BSON\ObjectID($folderId) ])->toArray();

			if (isset($document)) 
			{
				return 1;	
			}
			
		} catch (\Exception $e){
	        	return false;
	        } 
	}

	public static function updateData($payload)
	{
		$mongo 			 = new Mongo;
		$dbName 		 = "project";
		$collection_name = "newdata";
		$connection      = $mongo->$dbName->$collection_name;

		$condition = ['_id'  => new \MongoDB\BSON\ObjectID($payload['mongo_id'])];
		$set       = ['$set' => ['firstname' => $payload['firstname'], 'lastname' => $payload['lastname'], 'phone' => $payload['phone']]];

		$updateData = $connection->updateMany($condition, $set);
		 if (isset($updateData)) 
		 {
		 	return 1;
		 }
	}

	public static function deleteData($mongoID)
	{
		$mongo           = new Mongo;
		$dbName 		 = 'project';
		$collection_name = 'newdata';
		$connection      = $mongo->$dbName->$collection_name;

		$deleteData = $connection->deleteOne(['_id'  => new \MongoDB\BSON\ObjectID($mongoID)]);

		if (isset($deleteData)) 
		{
			return 1;
		}

	}
}
