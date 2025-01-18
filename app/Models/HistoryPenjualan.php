<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryPenjualan extends Model
{
    protected $table = 'history_penjualan';
    protected $fillable = ['bulan', 'tahun', 'jumlah'];
}
