<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;
use Crypt;

class signUp extends Model
{
    use HasFactory;
    
   public static function addData($value)
   {
      
   	   	 $insertData = 
   	 			[
   	 				"firstname"    => $value['firstname'],
   	 				"lastname" 	   => $value['lastname'],
   	 				"email"    	   => $value['email'],
   	 				"password" 	   => $value['password'],
   	 				"phone_number" => $value['phone_number'],
   	 				"subscription" => $value['subscription']
   	 			];

   	 $mainData = DB::table('sign_up')->insert($insertData);
   }


   public static function loginCredential($value)
   {
      $password = $value['password'];
      $signUpInsertedData = DB::table('sign_up')
                           ->select('*')
                           ->where('email',$value['email'])
                           ->get();    
      if (count($signUpInsertedData) == 0)
      {
         return false;
      }

      $storedPass = $signUpInsertedData[0]->password;
   
     if (crypt($password, $storedPass) === $storedPass) 
     {
       $query = "SELECT usr_id, firstname, lastname, password, phone_number, subscription FROM sign_up WHERE email ='" . $value['email']. "'";
            $pdo  = DB::connection()->getPdo();
            $stmt = $pdo->prepare($query);
            $res  = $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(count($data) > 0)
            {
                $returnData['data'] = $data[0];
            }

            return $returnData;
     }
     else
     {
       return false;
     }

   }
}
