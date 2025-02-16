<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    use HasFactory;

    protected $table = 'order_packages';
    protected $fillable = ['order_id', 'package_id', 'user_id', 'durasi', 'tanggal_mulai', 'tanggal_selesai', 'sesi', 'total_bayar', 'status_pembayaran', 'member_status', 'snap_token'];

    public function package()
    {
        return $this->belongsTo(ListPackage::class, 'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
