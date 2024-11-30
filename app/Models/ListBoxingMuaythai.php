<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListBoxingMuaythai extends Model
{
    use HasFactory;
    protected $table = 'list_boxing_muaythais';
    protected $fillable = ['sesi', 'harga_list', 'deskripsi'];

}
