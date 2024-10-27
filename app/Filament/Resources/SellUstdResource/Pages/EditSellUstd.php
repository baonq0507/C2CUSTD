<?php

namespace App\Filament\Resources\SellUstdResource\Pages;

use App\Filament\Resources\SellUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSellUstd extends EditRecord
{
    protected static string $resource = SellUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
