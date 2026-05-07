<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handleNotification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        Log::info('Midtrans Notification received:', ['payload' => $notification]);

        if (!$notification) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $serverKey = config('services.midtrans.server_key');
        $signatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . $serverKey);

        if ($signatureKey !== $notification->signature_key) {
            Log::warning('Midtrans Notification Signature mismatch!', ['order_id' => $notification->order_id]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status;

        $pesanan = Pesanan::where('kode_pesanan', $orderId)->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        try {
            DB::beginTransaction();

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $pesanan->update(['status' => 'menunggu_verifikasi']);
                    } else {
                        $pesanan->update(['status' => 'dikonfirmasi', 'dibayar_pada' => now()]);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $pesanan->update(['status' => 'dikonfirmasi', 'dibayar_pada' => now()]);
            } elseif ($transactionStatus == 'pending') {
                $pesanan->update(['status' => 'menunggu_bayar']);
            } elseif ($transactionStatus == 'deny') {
                $pesanan->update(['status' => 'dibatalkan']);
            } elseif ($transactionStatus == 'expire') {
                $pesanan->update(['status' => 'dibatalkan']);
            } elseif ($transactionStatus == 'cancel') {
                $pesanan->update(['status' => 'dibatalkan']);
            }

            DB::commit();
            return response()->json(['message' => 'Notification handled successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Callback Processing Error:', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
