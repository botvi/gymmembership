<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriMembership;
use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class WebHomeController extends Controller
{
    public function index()
    {
        $kategori_memberships = KategoriMembership::all();
        return view('pageweb.home.index', compact('kategori_memberships'));
    }

    public function transaksi(Request $request, $id)
    {
        $kategori_membership = KategoriMembership::findOrFail($id);
        $user = auth()->user();
        return view('pageweb.home.transaksi', compact('kategori_membership', 'user'));
    }



    public function addMembership(Request $request)
    {
        $request->validate([
            'kategori_membership_id' => 'required|exists:kategori_memberships,id',
            'user_id' => 'required|exists:users,id',
            'durasi_bulan' => 'required|integer|min:1',
            'total_bayar' => 'required|numeric'
        ]);

        // Validate total payment amount
        $kategori = KategoriMembership::findOrFail($request->kategori_membership_id);
        $expectedTotal = $kategori->harga * $request->durasi_bulan;

        if ($request->total_bayar != $expectedTotal) {
            Alert::error('Error', 'Invalid payment amount!');
            return redirect()->back();
        }

        
        // Check if user already has an pending transaction
        $existingPendingMembership = Membership::where('user_id', $request->user_id)
            ->where('status', 'pending')
            ->first();

        if ($existingPendingMembership) {
           $existingPendingMembership->delete();
        }
        
        // Check if user already has an success membership
        $existingSuccessMembership = Membership::where('user_id', $request->user_id)
            ->where('status', 'success')
            ->first();

        if ($existingSuccessMembership) {
           Alert::error('Error', 'User already has an active membership!');
           return redirect()->back();
        }

        $tanggal_mulai = Carbon::now();
        $tanggal_selesai = $tanggal_mulai->copy()->addMonths($request->durasi_bulan);

        // Midtrans API Configuration
        $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $authString = base64_encode($serverKey . ':');
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . $authString,
        ];

        // Prepare Midtrans payload
        $payload = [
            'transaction_details' => [
                'order_id' => 'TRX-' . random_int(1000000000, 9999999999),
                'gross_amount' => $request->total_bayar,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->nama,
                'email' => auth()->user()->email,
            ],
        ];

        // Request Snap Token
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            Alert::error('Error', 'Failed to connect to payment gateway: ' . curl_error($ch));
            return redirect()->back();
        }

        curl_close($ch);

        $midtransResponse = json_decode($response, true);

        if (isset($midtransResponse['token'])) {
            // Save to database
            Membership::create([
                'order_id' => $payload['transaction_details']['order_id'],
                'kategori_membership_id' => $request->kategori_membership_id,
                'user_id' => auth()->user()->id,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'durasi_bulan' => $request->durasi_bulan,
                'total_bayar' => $request->total_bayar,
                'snap_token' => $midtransResponse['token'],
                'status' => 'pending'
            ]);

            Alert::success('Success', 'Membership successfully created! Payment link generated.');
            return redirect()->route('web.transaksi_detail', $payload['transaction_details']['order_id']);
        } else {
            Alert::error('Error', 'Failed to generate payment token!');
            return redirect()->back();
        }
    }

    public function transaksi_detail($id)
    {
        $transaksi = Membership::where('user_id', auth()->user()->id)->latest()->first();
        return view('pageweb.home.transaksi_detail', compact('transaksi'));
    }

    public function success($order_id)
    {
        $user = auth()->user();
        $transaksi = Membership::where('user_id', $user->id)->where('order_id', $order_id)->latest()->first();
        $transaksi->status = 'success';
        $user->status = 'active';
        $transaksi->save();
        $user->save();
        return view('pageweb.home.success', compact('transaksi'));
    }
    
}
