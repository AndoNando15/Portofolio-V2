<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skill';
    protected $fillable = ['icon_skill', 'nama_skill', 'status'];

}