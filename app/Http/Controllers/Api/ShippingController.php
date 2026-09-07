<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    private function client()
    {
        return Http::withHeaders([
            'key' => config('services.rajaongkir.api_key'),
        ])->baseUrl(config('services.rajaongkir.base_url'));
    }

    public function destinations(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string', 'min:2'],
        ]);

        $response = $this->client()->get('/destination/domestic-destination', [
            'search' => $request->search,
            'limit' => 20,
            'offset' => 0,
        ]);

        return response()->json(
            $response->json(),
            $response->status()
        );
    }

    public function cost(Request $request)
    {
        $validated = $request->validate([
            'origin' => ['required', 'integer'],
            'destination' => ['required', 'integer'],
            'weight' => ['required', 'integer', 'min:1'],
            'courier' => ['required', 'string'],
        ]);

        $response = $this->client()
            ->asForm()
            ->post('/calculate/domestic-cost', [
                'origin' => $validated['origin'],
                'destination' => $validated['destination'],
                'weight' => $validated['weight'],
                'courier' => $validated['courier'],
                'price' => 'lowest',
            ]);

        return response()->json(
            $response->json(),
            $response->status()
        );
    }
}