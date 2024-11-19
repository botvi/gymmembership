<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMembership extends Model
{
    use HasFactory;
    protected $table = 'kategori_memberships';
    protected $fillable = ['nama_kategori', 'deskripsi', 'harga', 'periode'];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'kategori_membership_id');
    }
}
