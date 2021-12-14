<?php

namespace App\Http\Services\download;


use Illuminate\Support\Facades\Request;
use App\Exports\dataExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\downloadUsr;

class downloadServices 
{
     function exportservice($sortBY, $order, $status)
    {
  		//echo gettype($sortBY); echo "<br>"; echo gettype($sortBY); echo "<br>"; echo gettype($status);
        $Exports = new dataExport($sortBY);

         return $Exports;
    }



}
?>
