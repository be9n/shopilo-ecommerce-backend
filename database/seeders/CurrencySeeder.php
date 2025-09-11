<?php

namespace Database\Seeders;

use App\Http\Services\CurrencyService;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function __construct(private CurrencyService $currencyService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedInitialCurrencies();
        $this->currencyService->updateCurrencies();
    }

    public function seedInitialCurrencies(): void
    {
        foreach ($this->currencyService->getInitialRates() as $currency) {
            Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }
}
