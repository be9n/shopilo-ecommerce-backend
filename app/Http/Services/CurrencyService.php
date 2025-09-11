<?php

namespace App\Http\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    public function getInitialRates(): array
    {
        return [
            ['code' => 'USD', 'symbol' => '$', 'rate' => 1, 'is_default' => true],
            ['code' => 'EUR', 'symbol' => '€', 'rate' => 0.85],
            ['code' => 'SAR', 'symbol' => 'SAR', 'rate' => 3.75],
            ['code' => 'TRY', 'symbol' => '₺', 'rate' => 41.35],
            ['code' => 'SYP', 'symbol' => 'SYP', 'rate' => 11.30],
        ];
    }

    public function updateCurrencies(): void
    {
        $rates = $this->fetchRates();
        if (!$rates){
            return;
        }

        foreach (Currency::all() as $currency) {
            if (array_key_exists($currency->code, $rates)) {
                $currency->rate = round($rates[$currency->code], 2);
                $currency->save();
            }
        }
    }

    public function fetchRates(): ?array
    {
        $apiKey = config('services.exchange_rates.api_key');

        try {
            $response = Http::timeout(10)
                ->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD")
                ->json();

            if (!isset($response['result']) || $response['result'] !== 'success') {
                Log::error('ExchangeRate API failed: ' . ($response['error-type'] ?? 'unknown error'));
                return null;
            }

            return $response['conversion_rates'];
        } catch (\Exception $e) {
            Log::error('ExchangeRate API error: ' . $e->getMessage());
            return null;
        }
    }
}