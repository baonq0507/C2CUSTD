<?php

namespace App\Filament\Resources\TransactionDepositResource\Pages;

use App\Filament\Resources\TransactionDepositResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionDeposits extends ListRecords
{
    protected static string $resource = TransactionDepositResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
