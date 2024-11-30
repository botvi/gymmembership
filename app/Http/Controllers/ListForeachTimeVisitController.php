<?php

namespace App\Http\Controllers;

use App\Models\ListForeachTimeVisit;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class ListForeachTimeVisitController extends Controller
{
    public function index()
    {
        $membership = ListForeachTimeVisit::all();
        return view('pageadmin.list_foreach_time_visits.index', compact('membership'));
    }

    public function create()
    {
        return view('pageadmin.list_foreach_time_visits.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_list' => 'required|string|max:255',
            'durasi' => 'required|string|max:255',
            'harga_list' => 'required|integer',
        ]);



        ListForeachTimeVisit::create([
            'nama_list' => $request->nama_list,
            'durasi' => $request->durasi,
            'harga_list' => $request->harga_list,
        ]);

        Alert::success('Success', 'List Foreach Time Visit successfully created!');
        return redirect()->route('listforeachtimevisit.index');
    }



    public function edit($id)
    {
        $membership = ListForeachTimeVisit::findOrFail($id);
        
        return view('pageadmin.list_foreach_time_visits.edit', compact('membership'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_list' => 'required|string|max:255',
            'durasi' => 'required|string|max:255',
            'harga_list' => 'required|integer',
        ]);


        $membership = ListForeachTimeVisit::findOrFail($id);
        $membership->update([
            'nama_list' => $request->nama_list,
            'durasi' => $request->durasi,
            'harga_list' => $request->harga_list,
        ]);

        Alert::success('Success', 'List Foreach Time Visit successfully updated!');
        return redirect()->route('listforeachtimevisit.index');
    }



    public function destroy($id)
    {
        $membership = ListForeachTimeVisit::findOrFail($id);


        $membership->delete();

        Alert::success('Deleted', 'List Foreach Time Visit successfully deleted!');
        return redirect()->route('listforeachtimevisit.index');
    }
}
