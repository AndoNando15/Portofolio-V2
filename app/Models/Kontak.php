<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $fillable = ['icon_kontak', 'nama_kontak', 'keterangan_kontak', 'status', 'url'];
}