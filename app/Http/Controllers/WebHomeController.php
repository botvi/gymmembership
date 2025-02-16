<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListMembershipGym;
use App\Models\ListBoxingMuayThai;
use App\Models\ListPackage;
use App\Models\ListForeachTimeVisit;

class WebHomeController extends Controller
{
    public function index()
    {
        $listMembership = ListMembershipGym::all();
        $listBoxingMuayThai = ListBoxingMuayThai::all();
        $listPackage = ListPackage::all();
        $listForeachTimeVisit = ListForeachTimeVisit::all();
        return view('pageweb.home.index', compact('listMembership', 'listBoxingMuayThai', 'listPackage', 'listForeachTimeVisit'));
    }

    public function detailMembership($id)
    {
        $listMembership = ListMembershipGym::find($id);
        return view('pageweb.detail.detailMembership', compact('listMembership'));
    }
    public function detailBoxingMuayThai($id)
    {
        $listBoxingMuayThai = ListBoxingMuayThai::find($id);
        return view('pageweb.detail.detailBoxingMuayThai', compact('listBoxingMuayThai'));
    }
    public function detailPackage($id)
    {
        $listPackage = ListPackage::find($id);
        return view('pageweb.detail.detailPackage', compact('listPackage'));
    }
    public function detailForeachTimeVisit($id)
    {
        $listForeachTimeVisit = ListForeachTimeVisit::find($id);
        return view('pageweb.detail.detailForeachTimeVisit', compact('listForeachTimeVisit'));
    }
}
