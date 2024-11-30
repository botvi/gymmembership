<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPackage extends Model
{
    use HasFactory;
    protected $fillable = ['durasi', 'sesi', 'harga_list', 'fasilitas', 'deskripsi'];
    protected $casts = [
        'fasilitas' => 'array',
    ];
}
