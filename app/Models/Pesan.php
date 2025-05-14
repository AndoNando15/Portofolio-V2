<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $table = 'pesan';
    protected $fillable = ['nama', 'email', 'no_telepon', 'subjek', 'isi_pesan', 'status', 'balasan'];

}