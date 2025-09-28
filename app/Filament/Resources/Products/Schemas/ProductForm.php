<?php

namespace App\Filament\Resources\Products\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TranslatableTabs::make()->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('description'),
                ])->columns(2)->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                Toggle::make('active')
                    ->required(),
                Select::make('discount_id')
                    ->native(false)
                    ->relationship('discount', 'name'),
            ]);
    }
}
