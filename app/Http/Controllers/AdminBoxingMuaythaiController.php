<?php

namespace App\Http\Controllers;

use App\Models\OrderBoxingMuaythai;
use App\Models\User;
use App\Models\ListBoxingMuaythai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminBoxingMuaythaiController extends Controller
{

    public function index()
    {
        $memberships = OrderBoxingMuaythai::with('user', 'boxingMuaythai')->get();
        return view('pageadmin.boxing_muaythai.index', compact('memberships'));
    }


    public function create()
    {
        $users = User::all();
        $boxingMuaythais = ListBoxingMuaythai::all();
      

        return view('pageadmin.boxing_muaythai.create', compact('users', 'boxingMuaythais'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'boxing_muaythai_id' => 'required|exists:list_boxing_muaythais,id',
            'user_id' => 'required|exists:users,id',
            'sesi' => 'required',
            'total_bayar' => 'required',    

        ]);

         
        // Check if user already has an pending transaction
        $existingPendingMembership = OrderBoxingMuaythai::where('user_id', $request->user_id)
            ->where('status_pembayaran', 'pending')
            ->first();

        if ($existingPendingMembership) {
           $existingPendingMembership->delete();
        }
        
        // Check if user already has an success membership
        $existingSuccessMembership = OrderBoxingMuaythai::where('user_id', $request->user_id)
            ->where('member_status', 'active')
            ->first();

        if ($existingSuccessMembership) {
           Alert::error('Error', 'User already has an active membership!');
           return redirect()->back();
        }

      


        OrderBoxingMuaythai::create([
            'order_id' => 'TRX-' . random_int(1000000000, 9999999999),
            'boxing_muaythai_id' => $request->boxing_muaythai_id,
            'user_id' => $request->user_id,
            'sesi' => $request->sesi,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'member_status' => 'active',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);

        Alert::success('Success', 'Membership successfully created!');
        return redirect()->route('admin.boxing_muaythai.index');
    }


    public function edit($id)
    {
        $existingData = OrderBoxingMuaythai::find($id);
        $users = User::all();
        $boxingMuaythais = ListBoxingMuaythai::all();

        return view('pageadmin.boxing_muaythai.edit', compact('existingData', 'users', 'boxingMuaythais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'boxing_muaythai_id' => 'nullable|exists:list_boxing_muaythais,id',
            'user_id' => 'required|exists:users,id',
            'sesi' => 'required',
            'total_bayar' => 'required',
            'member_status' => 'nullable',
        ]);


        $membership = OrderBoxingMuaythai::find($id);
        $membership->update([
            'boxing_muaythai_id' => $request->boxing_muaythai_id,
            'user_id' => $request->user_id,
            'sesi' => $request->sesi,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'member_status' => 'active',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);
        Alert::success('Success', 'Membership successfully updated!');
        return redirect()->route('admin.boxing_muaythai.index');
    }


    public function destroy($id)
    {
        $membership = OrderBoxingMuaythai::find($id);
        $membership->delete();
        $user = User::find($membership->user_id);
        $user->update(['status' => 'nonaktif']);
        Alert::success('Success', 'Membership successfully deleted!');
        return redirect()->route('admin.boxing_muaythai.index');
    }
}
