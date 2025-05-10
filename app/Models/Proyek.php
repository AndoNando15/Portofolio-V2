<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';
    protected $fillable = ['thumbnail_proyek', 'judul_proyek', 'jenis_proyek', 'teknologi', 'detail_proyek', 'status'];
    public function gambarProyek()
    {
        return $this->hasMany(GambarProyek::class);
    }
}