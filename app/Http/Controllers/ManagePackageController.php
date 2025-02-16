<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderPackage;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class ManagePackageController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderPackage::with('user', 'package')
            ->where('status_pembayaran', 'success')
            ->orderByRaw("member_status = 'active' DESC");

        if ($request->filled('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }


        $package = $query->get();

        return view('pageadmin.manage.package.index', compact('package'));
    }
    public function updateSessionCount(Request $request, $id)
    {
        $package = OrderPackage::find($id);
        $newSessionCount = $package->sesi - 1;
        $package->sesi = $newSessionCount;

        if ($newSessionCount <= 0) {
            $package->member_status = 'not_active';
            Alert::info('Info', 'Sesi habis, status member tidak aktif.');
        } else {
            Alert::success('Success', 'Sesi dikurangi, status kehadiran berhasil diubah!');
        }

        $package->save();
        return redirect()->back();
    }

    public function checkAndUpdateMembershipStatus()
    {
        $today = now()->toDateString();
        $memberships = OrderPackage::where('tanggal_selesai', '<', $today)
            ->where('member_status', 'active')
            ->get();

        foreach ($memberships as $membership) {
            $membership->update(['member_status' => 'not_active']);
        }

        Alert::success('Periksa Selesai', 'Status keanggotaan telah diperbarui.');
        return back();
    }
}
