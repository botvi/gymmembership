<?php

namespace App\Http\Controllers;

use App\Models\OrderMembershipGym;
use App\Models\User;
use App\Models\ListMembershipGym;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminMembershipGymController extends Controller
{

    public function index()
    {
        $memberships = OrderMembershipGym::with('user', 'membershipGym')->get();
        return view('pageadmin.membership_gym.index', compact('memberships'));
    }


    public function create()
    {
        $users = User::all();
        $membershipGyms = ListMembershipGym::all();
      

        return view('pageadmin.membership_gym.create', compact('users', 'membershipGyms'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'membership_gym_id' => 'nullable|exists:list_membership_gyms,id',
            'user_id' => 'required|exists:users,id',
            'durasi' => 'required',
            'total_bayar' => 'required',
            'member_status' => 'nullable',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',

        ]);

         
        // Check if user already has an pending transaction
        $existingPendingMembership = OrderMembershipGym::where('user_id', $request->user_id)
            ->where('status_pembayaran', 'pending')
            ->first();

        if ($existingPendingMembership) {
           $existingPendingMembership->delete();
        }
        
        // Check if user already has an success membership
        $existingSuccessMembership = OrderMembershipGym::where('user_id', $request->user_id)
            ->where('member_status', 'active')
            ->first();

        if ($existingSuccessMembership) {
           Alert::error('Error', 'User already has an active membership!');
           return redirect()->back();
        }

      


        OrderMembershipGym::create([
            'order_id' => 'TRX-' . random_int(1000000000, 9999999999),
            'membership_gym_id' => $request->membership_gym_id,
            'user_id' => $request->user_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $request->durasi,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'member_status' => 'active',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);

        Alert::success('Success', 'Membership successfully created!');
        return redirect()->route('admin.membership_gym.index');
    }


    public function edit($id)
    {
        $membership = OrderMembershipGym::find($id);
        $users = User::all();
        $membershipGyms = ListMembershipGym::all();

        return view('pageadmin.membership_gym.edit', compact('membership', 'users', 'membershipGyms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'membership_gym_id' => 'nullable|exists:list_membership_gyms,id',
            'user_id' => 'required|exists:users,id',
            'durasi' => 'required',
            'total_bayar' => 'required',
            'member_status' => 'nullable',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);


        $membership = OrderMembershipGym::find($id);
        $membership->update([
            'membership_gym_id' => $request->membership_gym_id,
            'user_id' => $request->user_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $request->durasi,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'member_status' => 'active',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);
        Alert::success('Success', 'Membership successfully updated!');
        return redirect()->route('admin.membership_gym.index');
    }


    public function destroy($id)
    {
        $membership = OrderMembershipGym::find($id);
        $membership->delete();
        $user = User::find($membership->user_id);
        $user->update(['status' => 'nonaktif']);
        Alert::success('Success', 'Membership successfully deleted!');
        return redirect()->route('admin.membership_gym.index');
    }
}
