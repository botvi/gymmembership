<?php

namespace App\Http\Controllers;

use App\Models\ListPackage;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class ListPackageController extends Controller
{
    public function index()
    {
        $package = ListPackage::all();
        return view('pageadmin.list_package.index', compact('package'));
    }

    public function create()
    {
        return view('pageadmin.list_package.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'durasi' => 'required',
            'sesi' => 'required|string|max:255',
            'harga_list' => 'required',
            'deskripsi' => 'required',
            'fasilitas.*' => 'required',
        ]);

        $fasilitas = [$request->fasilitas];


        ListPackage::create([
            'durasi' => $request->durasi,
            'sesi' => $request->sesi,
            'harga_list' => $request->harga_list,
            'fasilitas' => json_encode($fasilitas),
            'deskripsi' => $request->deskripsi,
        ]);

        Alert::success('Success', 'List Package successfully created!');
        return redirect()->route('listpackage.index');
    }



    public function edit($id)
    {
        $package = ListPackage::findOrFail($id);

        // Decode fasilitas JSON
        $fasilitas = json_decode($package->fasilitas, true)[0];

        return view('pageadmin.list_package.edit', compact('package', 'fasilitas'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'durasi' => 'required',
            'sesi' => 'required|string|max:255',
            'harga_list' => 'required',
            'deskripsi' => 'required',
            'fasilitas.*' => 'required',
        ]);

        // Gabungkan semua fasilitas ke dalam array
        $fasilitas = [$request->fasilitas];

        $package = ListPackage::findOrFail($id);
        $package->update([
            'durasi' => $request->durasi,
            'sesi' => $request->sesi,
            'harga_list' => $request->harga_list,
            'fasilitas' => json_encode($fasilitas),
            'deskripsi' => $request->deskripsi,
        ]);

        Alert::success('Success', 'List Package successfully updated!');
        return redirect()->route('listpackage.index');
    }



    public function destroy($id)
    {
        $package = ListPackage::findOrFail($id);


        // Delete the merk record
        $package->delete();

        Alert::success('Deleted', 'List Package successfully deleted!');
        return redirect()->route('listpackage.index');
    }
}
