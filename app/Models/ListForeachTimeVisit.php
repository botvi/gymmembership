<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListForeachTimeVisit extends Model
{
    use HasFactory;

    protected $fillable = ['nama_list', 'durasi', 'harga_list'];
}
