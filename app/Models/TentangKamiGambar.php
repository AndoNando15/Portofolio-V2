<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentangKamiGambar extends Model
{
    protected $table = 'tentang_kami_gambar';
    protected $fillable = ['gambar', 'status'];
}