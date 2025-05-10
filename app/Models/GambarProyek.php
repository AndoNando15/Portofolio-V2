<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarProyek extends Model
{
    use HasFactory;
    protected $table = 'gambar_proyek';
    protected $fillable = ['proyek_id', 'gambar_path', 'status'];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
}