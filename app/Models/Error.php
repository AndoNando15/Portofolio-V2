<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $table = '404';
    protected $fillable = ['keterangan', 'status'];
}