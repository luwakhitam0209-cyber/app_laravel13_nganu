<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();

            $midtransOrderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $signatureKey = $notification->signature_key;

            /*
             * Verifikasi signature Midtrans
             *
             * SHA512:
             * order_id + status_code + gross_amount + server_key
             */
            $expectedSignature = hash(
                'sha512',
                $midtransOrderId .
                $notification->status_code .
                $notification->gross_amount .
                config('midtrans.server_key')
            );

            if (!hash_equals($expectedSignature, $signatureKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Signature tidak valid.',
                ], 403);
            }

            /*
             * Contoh:
             * HOMESTORE-10-1757212345
             *
             * 10 = ID order di database
             */
            $parts = explode('-', $midtransOrderId);

            if (
                count($parts) < 2 ||
                $parts[0] !== 'HOMESTORE'
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order ID tidak valid.',
                ], 400);
            }

            $orderIdDatabase = $parts[1];

            $order = Order::find($orderIdDatabase);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak ditemukan.',
                ], 404);
            }

            /*
             * UPDATE STATUS ORDER
             */

            if (
                $transactionStatus === 'capture' &&
                $fraudStatus === 'accept'
            ) {
                $order->update([
                    'status' => 'paid',
                ]);
            }

            elseif ($transactionStatus === 'settlement') {
                $order->update([
                    'status' => 'paid',
                ]);
            }

            elseif ($transactionStatus === 'pending') {
                $order->update([
                    'status' => 'pending',
                ]);
            }

            elseif (
                in_array($transactionStatus, [
                    'deny',
                    'cancel',
                    'expire',
                ])
            ) {
                $order->update([
                    'status' => 'failed',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Notification berhasil diproses.',
                'status' => $transactionStatus,
                'order_id' => $order->id,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}