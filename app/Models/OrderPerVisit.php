<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPerVisit extends Model
{
    use HasFactory;

    protected $table = 'order_per_visits';
    protected $fillable = ['order_id', 'foreach_time_visit_id', 'user_id', 'total_bayar', 'status_pembayaran', 'status_kehadiran', 'snap_token'];

    public function foreachTimeVisit()
    {
        return $this->belongsTo(ListForeachTimeVisit::class, 'foreach_time_visit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
