<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\User;
use App\Models\KategoriMembership;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminMembershipController extends Controller
{
   
    public function index()
    {
        $memberships = Membership::with('user', 'kategoriMembership')->get();
        return view('pageadmin.membership.index', compact('memberships'));
    }

  
    public function create()
    {
        $users = User::all();
        $kategoriMemberships = KategoriMembership::all();
        $durasiOptions = [
            1 => '1 Bulan',
            2 => '2 Bulan',
            3 => '3 Bulan',
            6 => '6 Bulan',
            12 => '12 Bulan',
        ];

        return view('pageadmin.membership.create', compact('users', 'kategoriMemberships', 'durasiOptions'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'kategori_membership_id' => 'required|exists:kategori_memberships,id',
            'user_id' => 'required|exists:users,id',
            'durasi_bulan' => 'required|integer|min:1',
            'jenis_pembayaran' => 'required|string',
            'total_bayar' => 'required'
        ]);

        // Check if user already has an active membership
        $existingMembership = Membership::where('user_id', $request->user_id)
            ->where('tanggal_selesai', '>', Carbon::now())
            ->first();

        if ($existingMembership) {
            Alert::error('Error', 'User already has an active membership!');
            return redirect()->back();
        }

        $tanggal_mulai = Carbon::now();
        $tanggal_selesai = $tanggal_mulai->copy()->addMonths($request->durasi_bulan);

        Membership::create([
            'kategori_membership_id' => $request->kategori_membership_id,
            'user_id' => $request->user_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'total_bayar' => $request->total_bayar,
            'jenis_pembayaran' => $request->jenis_pembayaran,
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);   

        Alert::success('Success', 'Membership successfully created!');
        return redirect()->route('admin.membership.index');
    }

 
    public function edit($id)
    {
        $membership = Membership::find($id);
        $users = User::all();
        $kategoriMemberships = KategoriMembership::all();
        $durasiOptions = [
            1 => '1 Bulan',
            2 => '2 Bulan',
            3 => '3 Bulan',
            6 => '6 Bulan',
            12 => '12 Bulan',
        ];
        return view('pageadmin.membership.edit', compact('membership', 'users', 'kategoriMemberships', 'durasiOptions'));    
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_membership_id' => 'required|exists:kategori_memberships,id',
            'user_id' => 'required|exists:users,id',
            'durasi_bulan' => 'required|integer|min:1',
            'jenis_pembayaran' => 'required|string',
            'total_bayar' => 'required'
        ]);

        $membership = Membership::find($id);
        $membership->update($request->all());
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);   
        Alert::success('Success', 'Membership successfully updated!');
        return redirect()->route('admin.membership.index');
    }

 
        public function destroy($id)
    {
        $membership = Membership::find($id);
        $membership->delete();
        $user = User::find($membership->user_id);
        $user->update(['status' => 'nonaktif']);    
        Alert::success('Success', 'Membership successfully deleted!');
        return redirect()->route('admin.membership.index');
    }
}
