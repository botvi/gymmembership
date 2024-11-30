<?php

namespace App\Http\Controllers;

use App\Models\ListMembershipGym;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class ListMembershipGymController extends Controller
{
    public function index()
    {
        $membership = ListMembershipGym::all();
        return view('pageadmin.list_membership_gym.index', compact('membership'));
    }

    public function create()
    {
        return view('pageadmin.list_membership_gym.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_list' => 'required|string|max:255',
            'harga_list' => 'required',
            'durasi' => 'required',
            'fasilitas.*' => 'required',
        ]);

        $fasilitas = [$request->fasilitas];


        ListMembershipGym::create([
            'nama_list' => $request->nama_list,
            'harga_list' => $request->harga_list,
            'durasi' => $request->durasi,
            'fasilitas' => json_encode($fasilitas),
        ]);

        Alert::success('Success', 'List Membership Gym successfully created!');
        return redirect()->route('listmembershipgym.index');
    }



    public function edit($id)
    {
        $membership = ListMembershipGym::findOrFail($id);

        // Decode fasilitas JSON
        $fasilitas = json_decode($membership->fasilitas, true)[0];

        return view('pageadmin.list_membership_gym.edit', compact('membership', 'fasilitas'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_list' => 'required|string|max:255',
            'harga_list' => 'required',
            'durasi' => 'required',
            'fasilitas.*' => 'required',
        ]);

        // Gabungkan semua fasilitas ke dalam array
        $fasilitas = [$request->fasilitas];

        $membership = ListMembershipGym::findOrFail($id);
        $membership->update([
            'nama_list' => $request->nama_list,
            'harga_list' => $request->harga_list,
            'durasi' => $request->durasi,
            'fasilitas' => json_encode($fasilitas),
        ]);

        Alert::success('Success', 'List Membership Gym successfully updated!');
        return redirect()->route('listmembershipgym.index');
    }



    public function destroy($id)
    {
        $membership = ListMembershipGym::findOrFail($id);


        // Delete the merk record
        $membership->delete();

        Alert::success('Deleted', 'List Membership Gym successfully deleted!');
        return redirect()->route('listmembershipgym.index');
    }
}
