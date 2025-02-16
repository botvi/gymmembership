<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderPerVisit;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class ManagePerVisitController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderPerVisit::with('user', 'foreachTimeVisit')
                 ->where('status_pembayaran', 'success')
                 ->orderByRaw("status_kehadiran = 'Belum Hadir' DESC");

        if ($request->filled('nama')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('nama_list')) {
            $query->whereHas('foreachTimeVisit', function ($q) use ($request) {
                $q->where('nama_list', 'like', '%' . $request->nama_list . '%');
            });
        }

        $perVisit = $query->get();

        return view('pageadmin.manage.per_visit.index', compact('perVisit'));
    }
    public function updateStatusKehadiran(Request $request, $id)
    {
        $perVisit = OrderPerVisit::find($id);
        $perVisit->update(['status_kehadiran' => 'Hadir']);
        Alert::success('Success', 'Status kehadiran berhasil diubah!');
        return redirect()->back();
    }
}
