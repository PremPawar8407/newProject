<?php

namespace App\Http\Services\Curl;


use Illuminate\Support\Facades\Request;
use App\Models\curlModel;


class curlServices 
{
     function checkCurl() 
     {
        return curlModel::checkCurl(); 
     }
      	
}
?>
