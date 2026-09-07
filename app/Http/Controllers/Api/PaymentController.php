<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id'
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],

            'shipping_cost' => [
                'required',
                'integer',
                'min:0'
            ],

            'shipping_destination' => [
                'required',
                'string'
            ],

            'shipping_courier' => [
                'required',
                'string'
            ],

            'shipping_service' => [
                'required',
                'string'
            ],
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $result = DB::transaction(function () use ($validated) {

                $total = 0;
                $items = [];

                // =========================
                // HITUNG TOTAL PRODUK
                // =========================
                foreach ($validated['items'] as $item) {

                    $product = Product::findOrFail(
                        $item['product_id']
                    );

                    if ($product->stock < $item['quantity']) {
                        abort(
                            422,
                            "Stok produk {$product->name} tidak mencukupi."
                        );
                    }

                    $subtotal =
                        $product->price *
                        $item['quantity'];

                    $total += $subtotal;

                    $items[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->price,
                    ];
                }

                // =========================
                // TAMBAHKAN ONGKIR
                // =========================
                $shippingCost =
                    (int) $validated['shipping_cost'];

                $total += $shippingCost;

                // =========================
                // BUAT ORDER
                // =========================
                $order = Order::create([
                    'user_id' => $validated['user_id'],
                    'status' => 'pending',
                ]);

                // =========================
                // ORDER DETAILS
                // =========================
                foreach ($items as $item) {

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                    ]);
                }

                // =========================
                // PAYMENT
                // =========================
                Payment::create([
                    'order_id' => $order->id,
                    'method' => 'midtrans',
                    'amount' => $total,
                ]);

                // =========================
                // ITEM MIDTRANS
                // =========================
                $midtransItems = [];

                foreach ($items as $item) {

                    $midtransItems[] = [
                        'id' => (string) $item['product']->id,
                        'price' => (int) $item['unit_price'],
                        'quantity' => $item['quantity'],
                        'name' => $item['product']->name,
                    ];
                }

                // Tambahkan ongkir sebagai item
                if ($shippingCost > 0) {

                    $midtransItems[] = [
                        'id' => 'SHIPPING',
                        'price' => $shippingCost,
                        'quantity' => 1,
                        'name' => 'Ongkos Kirim',
                    ];
                }

                // =========================
                // MIDTRANS PARAMETER
                // =========================
                $params = [
                    'transaction_details' => [
                        'order_id' =>
                            'HOMESTORE-' .
                            $order->id .
                            '-' .
                            time(),

                        'gross_amount' => $total,
                    ],

                    'item_details' => $midtransItems,
                ];

                $snapToken = Snap::getSnapToken($params);

                return [
                    'order_id' => $order->id,
                    'total' => $total,
                    'shipping_cost' => $shippingCost,
                    'snap_token' => $snapToken,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat.',
                'data' => $result,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}