<?php

namespace App\Filament\Resources\SellUstdResource\Pages;

use App\Filament\Resources\SellUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSellUstds extends ListRecords
{
    protected static string $resource = SellUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
