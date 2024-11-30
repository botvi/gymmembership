<?php

namespace App\Http\Controllers;

use App\Models\ListBoxingMuaythai;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class ListBoxingMuaythaiController extends Controller
{
    public function index()
    {
        $membership = ListBoxingMuaythai::all();
        return view('pageadmin.list_boxing_muaythai.index', compact('membership'));
    }

    public function create()
    {
        return view('pageadmin.list_boxing_muaythai.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'sesi' => 'required|string|max:255',
            'harga_list' => 'required|integer',
            'deskripsi' => 'required',
        ]);



        ListBoxingMuaythai::create([
            'sesi' => $request->sesi,
            'harga_list' => $request->harga_list,
            'deskripsi' => $request->deskripsi,
        ]);

        Alert::success('Success', 'List Boxing Muaythai successfully created!');
        return redirect()->route('listboxingmuaythai.index');
    }



    public function edit($id)
    {
        $membership = ListBoxingMuaythai::findOrFail($id);
        
        return view('pageadmin.list_boxing_muaythai.edit', compact('membership'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'sesi' => 'required|string|max:255',
            'harga_list' => 'required|integer',
            'deskripsi' => 'required',
        ]);


        $membership = ListBoxingMuaythai::findOrFail($id);
        $membership->update([
            'sesi' => $request->sesi,
            'harga_list' => $request->harga_list,
            'deskripsi' => $request->deskripsi,
        ]);

        Alert::success('Success', 'List Boxing Muaythai successfully updated!');
        return redirect()->route('listboxingmuaythai.index');
    }



    public function destroy($id)
    {
        $membership = ListBoxingMuaythai::findOrFail($id);


        $membership->delete();

        Alert::success('Deleted', 'List Boxing Muaythai successfully deleted!');
        return redirect()->route('listboxingmuaythai.index');
    }
}
