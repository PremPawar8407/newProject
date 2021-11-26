<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class details extends Model
{
    use HasFactory;
   protected $table="student";
   public $timestamps=false;
   /*
    function prem()
    {
  $data= DB::table('students')
              	->join('teacher','students.id','=','teacher.id')
              	//->select('students.id','students.firstname','students.lastname','students.student_phone','teacher.subject','teacher.name')
             // ->where('students.id',"2")
              	->get();
              }
*/
}
