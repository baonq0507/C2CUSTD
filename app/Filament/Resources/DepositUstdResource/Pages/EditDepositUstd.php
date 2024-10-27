<?php

namespace App\Filament\Resources\DepositUstdResource\Pages;

use App\Filament\Resources\DepositUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepositUstd extends EditRecord
{
    protected static string $resource = DepositUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
