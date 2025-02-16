<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('pageadmin.event.index', compact('events'));
    }

    public function create()
    {
        return view('pageadmin.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);

        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $posterName = time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(public_path('posters'), $posterName);

            $event = Event::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'lokasi' => $request->lokasi,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'poster' => $posterName,
            ]);

            Alert::success('Success', 'Event created successfully');
            return redirect()->route('events.index');
        } else {
            Alert::error('Error', 'Failed to upload poster');
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        $existingData = Event::find($id);
        return view('pageadmin.event.edit', compact('existingData'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
        ]);

        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $posterName = time() . '.' . $poster->getClientOriginalExtension();
            $poster->move(public_path('posters'), $posterName);
            $event->poster = $posterName;
        }

        $event->nama = $request->nama;
        $event->deskripsi = $request->deskripsi;
        $event->lokasi = $request->lokasi;
        $event->tanggal = $request->tanggal;
        $event->waktu = $request->waktu;

        $event->save();
        Alert::success('Success', 'Event updated successfully');
        return redirect()->route('events.index');
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        Alert::success('Success', 'Event deleted successfully');
        return redirect()->route('events.index');
    }
}
