<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = array('users_id', 'category_id', 'judul', 'gambar', 'ajakan', 'tanggal_mulai', 'tanggal_selesai', 'no_rekening', 'target_donasi', 'terkumpul','deskripsi', 'isPublished');

    public $timestamps = true;
}
