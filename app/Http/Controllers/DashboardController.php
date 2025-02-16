<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderPerVisit;
use App\Models\OrderMembershipGym;
use App\Models\OrderBoxingMuaythai;
use App\Models\OrderPackage;

class DashboardController extends Controller
{
   public function index()
   {
      $member_membership_gym = OrderMembershipGym::count();
      $member_boxing = OrderBoxingMuaythai::count();
      $member_package = OrderPackage::count();
      $member_foreach_time_visit = OrderPerVisit::count();

      return view('pageadmin.dashboard.index', compact('member_membership_gym', 'member_boxing', 'member_package', 'member_foreach_time_visit'));
   }
}
