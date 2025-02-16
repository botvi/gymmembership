<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderMembershipGym;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class ManageMembershipGymController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderMembershipGym::with('user', 'membershipGym')
                 ->where('status_pembayaran', 'success')
                 ->orderByRaw("member_status = 'active' DESC");

        if ($request->filled('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }


        $membershipGym = $query->get();

        return view('pageadmin.manage.membership_gym.index', compact('membershipGym'));
    }

    public function checkAndUpdateMembershipStatus()
    {
        $today = now()->toDateString();
        $memberships = OrderMembershipGym::where('tanggal_selesai', '<', $today)
                                         ->where('member_status', 'active')
                                         ->get();

        foreach ($memberships as $membership) {
            $membership->update(['member_status' => 'not_active']);
        }

        Alert::success('Periksa Selesai', 'Status keanggotaan telah diperbarui.');
        return back();
    }
}
