<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMembershipGym extends Model
{
    use HasFactory;
    protected $table = 'order_membership_gym';
    protected $fillable = ['order_id', 'membership_gym_id', 'user_id', 'tanggal_mulai', 'tanggal_selesai', 'durasi', 'total_bayar', 'status_pembayaran', 'member_status', 'snap_token'];

    public function membershipGym()
    {
        return $this->belongsTo(ListMembershipGym::class, 'membership_gym_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
