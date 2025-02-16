<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderBoxingMuaythai;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class ManageBoxingMuaythaiController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderBoxingMuaythai::with('user', 'boxingMuaythai')
                 ->where('status_pembayaran', 'success')
                 ->orderByRaw("member_status = 'active' DESC");

        if ($request->filled('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }
        

        $boxingMuaythai = $query->get();

        return view('pageadmin.manage.boxing_muaythai.index', compact('boxingMuaythai'));
    }
    public function updateSessionCount(Request $request, $id)
    {
        $boxingMuaythai = OrderBoxingMuaythai::find($id);
        $newSessionCount = $boxingMuaythai->sesi - 1;
        $boxingMuaythai->sesi = $newSessionCount;

        if ($newSessionCount <= 0) {
            $boxingMuaythai->member_status = 'not_active';
            Alert::info('Info', 'Sesi habis, status member tidak aktif.');
        } else {
            Alert::success('Success', 'Sesi dikurangi, status kehadiran berhasil diubah!');
        }

        $boxingMuaythai->save();
        return redirect()->back();
    }
}
