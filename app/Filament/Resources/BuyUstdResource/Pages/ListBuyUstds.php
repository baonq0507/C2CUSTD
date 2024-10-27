<?php

namespace App\Filament\Resources\BuyUstdResource\Pages;

use App\Filament\Resources\BuyUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBuyUstds extends ListRecords
{
    protected static string $resource = BuyUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
