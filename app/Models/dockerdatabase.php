<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dockerdatabase extends Model
{
    use HasFactory;
   protected $table='employee';
    public $timestamps=false;
}
