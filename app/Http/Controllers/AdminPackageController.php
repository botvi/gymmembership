<?php

namespace App\Http\Controllers;

use App\Models\OrderPackage;
use App\Models\User;
use App\Models\ListPackage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPackageController extends Controller
{

    public function index()
    {
        $memberships = OrderPackage::with('user', 'package')->get();
        return view('pageadmin.package.index', compact('memberships'));
    }


    public function create()
    {
        $users = User::all();
        $packages = ListPackage::all();
      

        return view('pageadmin.package.create', compact('users', 'packages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'nullable|exists:list_packages,id',
            'user_id' => 'required|exists:users,id',
            'durasi' => 'required',
            'total_bayar' => 'required',
            'member_status' => 'nullable',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'sesi' => 'required',
        ]);

         
        // Check if user already has an pending transaction
        $existingPendingMembership = OrderPackage::where('user_id', $request->user_id)
            ->where('status_pembayaran', 'pending')
            ->first();

        if ($existingPendingMembership) {
           $existingPendingMembership->delete();
        }
        
        // Check if user already has an success membership
        $existingSuccessMembership = OrderPackage::where('user_id', $request->user_id)
            ->where('member_status', 'active')
            ->first();

        if ($existingSuccessMembership) {
           Alert::error('Error', 'User already has an active membership!');
           return redirect()->back();
        }

      


        OrderPackage::create([
            'order_id' => 'TRX-' . random_int(1000000000, 9999999999),
            'package_id' => $request->package_id,
            'user_id' => $request->user_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,     
            'durasi' => $request->durasi,
            'sesi' => $request->sesi,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'member_status' => 'active',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);

        Alert::success('Success', 'Package successfully created!');
        return redirect()->route('admin.package.index');
    }


    public function edit($id)
    {
        $membership = OrderPackage::find($id);
        $users = User::all();
        $packages = ListPackage::all();

        return view('pageadmin.package.edit', compact('membership', 'users', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'package_id' => 'nullable|exists:list_packages,id',
            'user_id' => 'required|exists:users,id',
            'durasi' => 'required',
            'total_bayar' => 'required',
            'member_status' => 'nullable',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'sesi' => 'required',
        ]);


        $membership = OrderPackage::find($id);
        $membership->update([
            'package_id' => $request->package_id,
            'user_id' => $request->user_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $request->durasi,
            'sesi' => $request->sesi,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'member_status' => 'active',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);
        Alert::success('Success', 'Package successfully updated!');
        return redirect()->route('admin.package.index');
    }


    public function destroy($id)
    {
        $membership = OrderPackage::find($id);
        $membership->delete();
        $user = User::find($membership->user_id);
        $user->update(['status' => 'nonaktif']);
        Alert::success('Success', 'Package successfully deleted!');
        return redirect()->route('admin.package.index');
    }
}
