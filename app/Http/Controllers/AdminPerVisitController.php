<?php

namespace App\Http\Controllers;

use App\Models\OrderPerVisit;
use App\Models\User;
use App\Models\ListForeachTimeVisit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPerVisitController extends Controller
{

    public function index()
    {
        $memberships = OrderPerVisit::with('user', 'foreachTimeVisit')->get();
        return view('pageadmin.per_visit.index', compact('memberships'));
    }


    public function create()
    {
        $users = User::all();
        $foreachTimeVisits = ListForeachTimeVisit::all();
      

        return view('pageadmin.per_visit.create', compact('users', 'foreachTimeVisits'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'foreach_time_visit_id' => 'nullable|exists:list_foreach_time_visits,id',
            'user_id' => 'required|exists:users,id',
            'total_bayar' => 'required',
            'status_pembayaran' => 'nullable',
            'status_kehadiran' => 'nullable',

        ]);

         
        // Check if user already has an pending transaction
        $existingPendingMembership = OrderPerVisit::where('user_id', $request->user_id)
            ->where('status_pembayaran', 'pending')
            ->first();

        if ($existingPendingMembership) {
           $existingPendingMembership->delete();
        }
        
        // Check if user already has an success membership
        $existingSuccessMembership = OrderPerVisit::where('user_id', $request->user_id)
            ->where('status_kehadiran', 'Belum Hadir')
            ->first();

        if ($existingSuccessMembership) {
           Alert::error('Error', 'User Belum Hadir di per visit sebelumnya!');
           return redirect()->back();
        }

      


        OrderPerVisit::create([
            'order_id' => 'TRX-' . random_int(1000000000, 9999999999),
            'foreach_time_visit_id' => $request->foreach_time_visit_id,
            'user_id' => $request->user_id,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'status_kehadiran' => 'Hadir',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);

        Alert::success('Success', 'Foreach Time Visit successfully created!');
        return redirect()->route('admin.per_visit.index');
    }


    public function edit($id)
    {
        $perVisit = OrderPerVisit::find($id);
        $users = User::all();
        $foreachTimeVisits = ListForeachTimeVisit::all();

        return view('pageadmin.per_visit.edit', compact('perVisit', 'users', 'foreachTimeVisits'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'foreach_time_visit_id' => 'nullable|exists:list_foreach_time_visits,id',
            'user_id' => 'required|exists:users,id',
            'total_bayar' => 'required',
            'status_pembayaran' => 'nullable',
            'status_kehadiran' => 'nullable',
        ]);


        $membership = OrderPerVisit::find($id);
        $membership->update([
            'foreach_time_visit_id' => $request->foreach_time_visit_id,
            'user_id' => $request->user_id,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'success',
            'status_kehadiran' => 'Hadir',
        ]);
        $user = User::find($request->user_id);
        $user->update(['status' => 'active']);
        Alert::success('Success', 'Foreach Time Visit successfully updated!');
        return redirect()->route('admin.per_visit.index');
    }


    public function destroy($id)
    {
        $membership = OrderPerVisit::find($id);
        $membership->delete();
        $user = User::find($membership->user_id);
        $user->update(['status' => 'nonaktif']);
        Alert::success('Success', 'Foreach Time Visit successfully deleted!');
        return redirect()->route('admin.per_visit.index');
    }
}
