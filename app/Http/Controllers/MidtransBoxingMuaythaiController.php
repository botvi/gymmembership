<?php

namespace App\Http\Controllers;

use App\Models\ListBoxingMuaythai;
use Illuminate\Http\Request;
use App\Models\OrderBoxingMuaythai;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class MidtransBoxingMuaythaiController extends Controller
{
    public function addBoxingMuaythai(Request $request)
    {
        $request->validate([
            'boxing_muaythai_id' => 'required|exists:list_boxing_muaythais,id',
            'user_id' => 'required|exists:users,id',
            'sesi' => 'required|integer|min:1',
            'total_bayar' => 'required|numeric'
        ]);

        $list_boxing_muaythai = ListBoxingMuaythai::findOrFail($request->boxing_muaythai_id);


        $existingPendingMembership = OrderBoxingMuaythai::where('user_id', $request->user_id)
            ->where('member_status', 'not_active')
            ->first();

        if ($existingPendingMembership) {
            $existingPendingMembership->delete();
        }

        $existingSuccessMembership = OrderBoxingMuaythai::where('user_id', $request->user_id)
            ->where('member_status', 'active')
            ->first();

        if ($existingSuccessMembership) {
            Alert::error('Error', 'User already has an active membership!');
            return redirect()->back();
        }

        $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $authString = base64_encode($serverKey . ':');
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . $authString,
        ];

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

        try {
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
                throw new \Exception(curl_error($ch));
            }

            curl_close($ch);

            $midtransResponse = json_decode($response, true);

            if (isset($midtransResponse['token'])) {
                OrderBoxingMuaythai::create([
                    'order_id' => $payload['transaction_details']['order_id'],
                    'boxing_muaythai_id' => $request->boxing_muaythai_id,
                    'user_id' => auth()->id(),
                    'sesi' => $request->sesi,
                    'total_bayar' => $request->total_bayar,
                    'snap_token' => $midtransResponse['token'],
                    'member_status' => 'not_active',
                    'status_pembayaran' => 'pending'
                ]);

                Alert::success('Success', 'Membership successfully created! Payment link generated.');
                return redirect()->route('web.transaksi_detail_boxing_muaythai', $payload['transaction_details']['order_id']);
            } else {
                throw new \Exception('Failed to generate payment link!');
            }
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function transaksi_detail($id)
    {
        $transaksi = OrderBoxingMuaythai::where('user_id', auth()->id())->where('order_id', $id)->latest()->firstOrFail();
        return view('pageweb.transaksi.pay_boxing_muaythai', compact('transaksi'));
    }

    public function success($order_id)
    {
        $transaksi = OrderBoxingMuaythai::where('user_id', auth()->id())
            ->where('order_id', $order_id)
            ->latest()
            ->firstOrFail();

        $transaksi->update(['status_pembayaran' => 'success']);
        $transaksi->update(['member_status' => 'active']);

        return view('pageweb.success.boxing_muaythai', compact('transaksi'));
    }
}
