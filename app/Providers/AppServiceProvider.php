<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();
        Schema::defaultStringLength(125);

        JsonResource::withoutWrapping();

        RedirectResponse::macro('withAlert', function ($message, $type = 'success') {
            return $this->with('alert', [
                'message' => $message,
                'type' => $type
            ]);
        });
    }
}
