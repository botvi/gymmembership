<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBoxingMuaythai extends Model
{
    use HasFactory;

    protected $table = 'order_boxing_muaythai';
    protected $fillable = ['order_id', 'boxing_muaythai_id', 'user_id', 'sesi', 'total_bayar', 'status_pembayaran', 'member_status', 'snap_token'];

    public function boxingMuaythai()
    {
        return $this->belongsTo(ListBoxingMuaythai::class, 'boxing_muaythai_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
