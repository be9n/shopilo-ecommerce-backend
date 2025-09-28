<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DiscountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('type'),
                TextEntry::make('value')
                    ->numeric(),
                TextEntry::make('start_date')
                    ->dateTime(),
                TextEntry::make('end_date')
                    ->dateTime(),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('max_uses')
                    ->numeric(),
                TextEntry::make('used_count')
                    ->numeric(),
                TextEntry::make('max_uses_per_user')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
