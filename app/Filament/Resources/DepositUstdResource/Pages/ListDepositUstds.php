<?php

namespace App\Filament\Resources\DepositUstdResource\Pages;

use App\Filament\Resources\DepositUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepositUstds extends ListRecords
{
    protected static string $resource = DepositUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
