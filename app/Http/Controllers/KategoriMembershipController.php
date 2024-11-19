<?php

namespace App\Http\Controllers;

use App\Models\KategoriMembership;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class KategoriMembershipController extends Controller
{
    public function index()
    {
        $membership = KategoriMembership::all();
        return view('pageadmin.kategori_membership.index', compact('membership'));
    }

    public function create()
    {
        return view('pageadmin.kategori_membership.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required',
        ]);

       
        KategoriMembership::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'periode' => 'Per Bulan',
        ]);

        Alert::success('Success', 'Kategori Membership successfully created!');
        return redirect()->route('kategorimembership.index');
    }



    public function edit($id)
    {
        $membership = KategoriMembership::findOrFail($id);
        return view('pageadmin.kategori_membership.edit', compact('membership'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required',
        ]);

        $membership = KategoriMembership::findOrFail($id);

       

            $membership->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'periode' => 'Per Bulan',
        ]);

        Alert::success('Success', 'Kategori Membership successfully updated!');
        return redirect()->route('kategorimembership.index');
    }

    public function destroy($id)
    {
        $membership = KategoriMembership::findOrFail($id);

     

        // Delete the merk record
        $membership->delete();

        Alert::success('Deleted', 'Kategori Membership successfully deleted!');
        return redirect()->route('kategorimembership.index');
    }
}