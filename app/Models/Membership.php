<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
    protected $table = 'memberships';
    protected $fillable = ['kategori_membership_id', 'user_id', 'tanggal_mulai', 'tanggal_selesai', 'total_bayar', 'jenis_pembayaran'];

    public function kategoriMembership()
    {
        return $this->belongsTo(KategoriMembership::class, 'kategori_membership_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
