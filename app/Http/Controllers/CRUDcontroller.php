<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CRUD_table;
class CRUDcontroller extends Controller
{
    
    function display(Request $req)
    {
    	$data=CRUD_table::all();
    	return view("display",['data'=>$data]);
    }
    
   
    function delete(request $request,$id)
    {
     CRUD_table::destroy(array('id',$id));
     return redirect("CRUD_show");

    }
    function insert(Request $request)
    {
        $insert=new CRUD_table;
        $insert->firstname=$request->firstname;
        $insert->lastname=$request->lastname;
        $insert->save();
        return redirect("CRUD_show");
    }
    function update($id)
    {
        $data = CRUD_table::find($id);
        return view("updateform",['data'=>$data]);
    }
    function edit($id,request $request)
    {
       $req=CRUD_table::find($id);
       $req->firstname=$request->firstname;
       $req->lastname=$request->lastname;
       $req->save();
       return redirect("CRUD_show");

    }
     
}
