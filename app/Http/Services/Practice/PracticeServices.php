<?php

namespace App\Http\Services\Practice;

use App\Models\signUp;
use Illuminate\Support\Facades\Request;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
//use Illuminate\Http\Request;


class PracticeServices 
 
    {

    public  function insertData($payload) 
    {
        //when insert data make crypt password and encode password.. 
       $majorsalt = env('AUTH_SALT', '');
       $payload['password']   = crypt($this->_encode($payload['password'], $majorsalt), $majorsalt);

        $signUp   = new signUp;
        $mainData = $signUp::addData($payload);
        return $mainData;


    }

    public  function setRedisDetail($payload) 
    {

        $signUpModel   = new signUp;
        $getData       = $signUpModel->showData($payload);
        $token         = str_shuffle(md5($getData));
        $setRedis      = Redis::connection();
        $data          = $setRedis->set('user' .$token, json_encode($getData));
        return $data;
        


    }

    function _encode($password, $majorsalt)
    {

        // if PHP5
        if (function_exists('str_split'))
        {
            $_pass = str_split($password);
        }

        // encrypts every single letter of the password
        foreach ($_pass as $_hashpass)
        {
            $majorsalt .= md5($_hashpass);
        }

        // encrypts the string combinations of every single encrypted letter
        // and finally returns the encrypted password
        return md5($majorsalt);
    }

    function checkcredential($payload)
    {
        //when check credential check U are when sign-up password encode or not if password encoded u are compulsory make encode password when u are check credential..
        $majorsalt = env('AUTH_SALT', '');
        $payload['password'] = $this->_encode($payload['password'], $majorsalt);   
        $credentialData  = new signUp;
        $getData         = $credentialData->loginCredential($payload);

        if (empty($getData)) 
        {
            return false;
        }
        
        $token         = str_shuffle(md5(date("hh-mm-yyyy-H:i:s")));
        $setRedis      = Redis::connection();
        $data          = $setRedis->set('user' .$token, json_encode($getData));
        return array("session-token" =>$token, "usr_data" => $getData);
    }

    function checkUserDataToken($token)
    {
        $getRedis   = Redis::connection();
        $usrData    = $getRedis->get('user' .$token);
        if (boolval($usrData) == true) {
            return $usrData;
        }else
        {
            return false;
        }
    }

    /*function check()
    {
        return "prem";
    }*/
    	
}
?>
