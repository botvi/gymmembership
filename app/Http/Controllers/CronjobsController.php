<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CronjobsController extends Controller
{
    public function checkAndUpdateAllMembershipStatus()
    {
        // Logika dari ManagePackageController
        app(\App\Http\Controllers\ManagePackageController::class)->checkAndUpdateMembershipStatus();

        // Logika dari ManageMembershipGymController
        app(\App\Http\Controllers\ManageMembershipGymController::class)->checkAndUpdateMembershipStatus();

        return response()->json(['status' => 'success', 'message' => 'All membership statuses updated successfully']);
    }
}


// contoh di server
// * * * * * curl -s http://yourdomain.com/cronjobs/check

// kalau tidak bisa gunakan schedule
// php artisan schedule:work