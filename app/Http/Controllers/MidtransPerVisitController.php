<?php

namespace App\Http\Controllers;

use App\Models\ListForeachTimeVisit;
use Illuminate\Http\Request;
use App\Models\OrderPerVisit;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class MidtransPerVisitController extends Controller
{
    public function addPerVisit(Request $request)
    {
        $request->validate([
            'foreach_time_visit_id' => 'required|exists:list_foreach_time_visits,id',
            'user_id' => 'required|exists:users,id',
            'total_bayar' => 'required|numeric'
        ]);

        $list_foreach_time_visit = ListForeachTimeVisit::findOrFail($request->foreach_time_visit_id);


        $existingSuccessMembership = OrderPerVisit::where('user_id', $request->user_id)
            ->where('status_kehadiran', 'Belum Hadir')
            ->first();

        if ($existingSuccessMembership) {
            Alert::error('Error', 'Kamu belum hadir di per visit sebelumnya!');
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
                OrderPerVisit::create([
                    'order_id' => $payload['transaction_details']['order_id'],
                    'foreach_time_visit_id' => $request->foreach_time_visit_id,
                    'user_id' => auth()->id(),
                    'total_bayar' => $request->total_bayar,
                    'snap_token' => $midtransResponse['token'],
                    'status_pembayaran' => 'pending',
                    'status_kehadiran' => 'Belum Hadir',
                ]);

                Alert::success('Success', 'Per Visit successfully created! Payment link generated.');
                return redirect()->route('web.transaksi_detail_per_visit', $payload['transaction_details']['order_id']);
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
        $transaksi = OrderPerVisit::where('user_id', auth()->id())->where('order_id', $id)->latest()->firstOrFail();
        return view('pageweb.transaksi.pay_per_visit', compact('transaksi'));
    }

    public function success($order_id)
    {
        $transaksi = OrderPerVisit::where('user_id', auth()->id())
            ->where('order_id', $order_id)
            ->latest()
            ->firstOrFail();

        $transaksi->update(['status_pembayaran' => 'success']);

        return view('pageweb.success.per_visit', compact('transaksi'));
    }
}
