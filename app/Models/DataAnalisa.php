<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnalisa extends Model
{
    use HasFactory;

    protected $table = 'data_analisa';

    protected $fillable = [
        'key',
        'bulan',
        'tahun',
        'At',
        'Ft',
        'APE',
        'total_mape',
    ];
}
