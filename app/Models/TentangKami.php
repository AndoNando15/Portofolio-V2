<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentangKami extends Model
{
    protected $table = 'tentang_kami';
    protected $fillable = ['nama_lengkap', 'pekerjaan', 'deskripsi_cv', 'file_cv', 'gambar', 'status'];

}