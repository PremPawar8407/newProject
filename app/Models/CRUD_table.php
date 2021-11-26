<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRUD_table extends Model
{
    use HasFactory;
   protected $table="products";
    public $timestamps=false;
}
