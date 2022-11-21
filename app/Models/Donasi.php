<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $fillable = array('program_id', 'users_id', 'id_transaksi', 'nama_donatur', 'email', 'nominal_donasi', 'dukungan', 'bukti_pembayaran', 'isVerified');

    public $timestamps = true;
}
