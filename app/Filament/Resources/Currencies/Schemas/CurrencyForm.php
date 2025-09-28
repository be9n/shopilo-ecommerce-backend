<?php

namespace App\Filament\Resources\Currencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CurrencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('symbol')
                    ->required(),
                TextInput::make('rate')
                    ->required()
                    ->numeric(),
                Toggle::make('is_default')
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
