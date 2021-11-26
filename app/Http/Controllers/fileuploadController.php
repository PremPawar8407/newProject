<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class fileuploadController extends Controller
{
    function img(Request $request)
    {
    return  $path = $request->file('file')->store('img');

    }
}
