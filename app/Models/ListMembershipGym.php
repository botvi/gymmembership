<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMembershipGym extends Model
{
    use HasFactory;
    protected $table = 'list_membership_gyms';
    protected $fillable = ['nama_list', 'harga_list', 'durasi', 'fasilitas'];

    protected $casts = [
        'fasilitas' => 'array',
    ];
    
        
}
