<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['referral_code'] = Str::random(6);
        $data['name'] = $data['username'];
        return $data;
    }
}
