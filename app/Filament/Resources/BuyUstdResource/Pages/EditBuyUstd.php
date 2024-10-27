<?php

namespace App\Filament\Resources\BuyUstdResource\Pages;

use App\Filament\Resources\BuyUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBuyUstd extends EditRecord
{
    protected static string $resource = BuyUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
