<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judul extends Model
{
    protected $table = 'judul';
    protected $fillable = ['judul', 'kemampuan', 'status'];
}