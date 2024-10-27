<?php

namespace App\Filament\Resources\TransactionUstdResource\Pages;

use App\Filament\Resources\TransactionUstdResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionUstd extends EditRecord
{
    protected static string $resource = TransactionUstdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
