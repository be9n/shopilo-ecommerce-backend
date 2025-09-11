<?php

namespace App\Console\Commands;

use App\Http\Services\CurrencyService;
use Illuminate\Console\Command;

class UpdateCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:update';
    protected $description = 'Update currency exchange rates from API';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyService $currencyService)
    {
        $currencyService->updateCurrencies();
        $this->info('✅ Currency rates updated successfully.');
    }
}
