<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.biteship.api_url');
        $this->apiKey = config('services.biteship.api_key');
    }

    public function createShipmentOrder($payload)
    {
        // Kirim permintaan HTTP POST ke API Biteship untuk membuat pesanan pengiriman
        $response = Http::post($this->apiUrl . '/shipments', $payload, [
            'Authorization' => 'Bearer ' . $this->apiKey,
        ]);

        // Handle response dan kembalikan hasilnya
        return $response->json();
    }

    public function getAreaId($payload)
    {
        // Kirim permintaan HTTP POST ke API Biteship untuk mendapatkan area ID
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->apiUrl . '/maps/areas?countries=ID&input='.$payload.'&type=single');

        // Handle response dan kembalikan hasilnya
        return $response->json();
    }

     

    public function getLocation($payload)
    {
        // Kirim permintaan HTTP POST ke API Biteship untuk mendapatkan area ID
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->apiUrl . '/locations/'.$payload);

        // Handle response dan kembalikan hasilnya
        return $response->json();
    }
    public function getCourierRate($payload)
    {
        // Kirim permintaan HTTP POST ke API Biteship untuk mendapatkan area ID
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl . '/rates/couriers',$payload);

        // Handle response dan kembalikan hasilnya
        return $response->json();
    }
}
