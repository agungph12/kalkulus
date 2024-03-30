<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menghitung extends Model
{
    use HasFactory;
    protected $table = 'menghitung';
    protected $fillable = [
        'equation',
        'type',
        'result'
    ];
}
