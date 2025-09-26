<?php

namespace Database\Seeders;

use App\Http\Services\CurrencyService;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function __construct()
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(CurrencyService $currencyService): void
    {
        $this->seedInitialCurrencies();
        $currencyService->updateCurrencies();
    }

    public function seedInitialCurrencies(): void
    {
        foreach ($this->getInitialRates() as $currency) {
            Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }

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
}
