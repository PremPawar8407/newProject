<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\accessormodel;
class accessorController extends Controller
{
    //
    function showdata(Request $req)
    {
    	return accessormodel::all();
    }
}
