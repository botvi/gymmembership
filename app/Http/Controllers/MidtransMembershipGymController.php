<?php

namespace App\Http\Controllers;

use App\Models\ListMembershipGym;
use Illuminate\Http\Request;
use App\Models\OrderMembershipGym;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class MidtransMembershipGymController extends Controller
{
    public function addMembership(Request $request)
    {
        $request->validate([
            'membership_gym_id' => 'required|exists:list_membership_gyms,id',
            'user_id' => 'required|exists:users,id',
            'durasi' => 'required|integer|min:1',
            'total_bayar' => 'required|numeric'
        ]);

        $list_membership_gym = ListMembershipGym::findOrFail($request->membership_gym_id);


        $existingPendingMembership = OrderMembershipGym::where('user_id', $request->user_id)
            ->where('member_status', 'not_active')
            ->first();

        if ($existingPendingMembership) {
            $existingPendingMembership->delete();
        }

        $existingSuccessMembership = OrderMembershipGym::where('user_id', $request->user_id)
            ->where('member_status', 'active')
            ->first();

        if ($existingSuccessMembership) {
            Alert::error('Error', 'User already has an active membership!');
            return redirect()->back();
        }

        $tanggal_mulai = Carbon::now();
        $tanggal_selesai = $tanggal_mulai->copy()->addDays($request->durasi);

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
                OrderMembershipGym::create([
                    'order_id' => $payload['transaction_details']['order_id'],
                    'membership_gym_id' => $request->membership_gym_id,
                    'user_id' => auth()->id(),
                    'tanggal_mulai' => $tanggal_mulai,
                    'tanggal_selesai' => $tanggal_selesai,
                    'durasi' => $request->durasi,
                    'total_bayar' => $request->total_bayar,
                    'snap_token' => $midtransResponse['token'],
                    'member_status' => 'not_active',
                    'status_pembayaran' => 'pending'
                ]);

                Alert::success('Success', 'Membership successfully created! Payment link generated.');
                return redirect()->route('web.transaksi_detail_membership_gym', $payload['transaction_details']['order_id']);
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
        $transaksi = OrderMembershipGym::where('user_id', auth()->id())->where('order_id', $id)->latest()->firstOrFail();
        return view('pageweb.transaksi.pay_membership_gym', compact('transaksi'));
    }

    public function success($order_id)
    {
        $transaksi = OrderMembershipGym::where('user_id', auth()->id())
            ->where('order_id', $order_id)
            ->latest()
            ->firstOrFail();

        $transaksi->update(['status_pembayaran' => 'success']);
        $transaksi->update(['member_status' => 'active']);

        return view('pageweb.success.membership_gym', compact('transaksi'));
    }
}
