<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositUstdResource\Pages;
use App\Filament\Resources\DepositUstdResource\RelationManagers;
use App\Models\DepositUstd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
class DepositUstdResource extends Resource
{
    protected static ?string $model = DepositUstd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cấu hình';

    protected static ?string $navigationLabel = 'Ví USTD';

    protected static ?string $label = 'Ví USTD';

    //query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('id', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')->label('Tên ví'),
                TextInput::make('address')->label('Địa chỉ ví'),
                //status
                Select::make('status')->label('Trạng thái')->options([
                    'active' => 'Hoạt động',
                    'inactive' => 'Không hoạt động',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->label('Tên ví'),
                TextColumn::make('address')->label('Địa chỉ ví'),
                TextColumn::make('status')->label('Trạng thái')->badge()->color(fn($state) => $state == 'active' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == 'active' ? 'Hoạt động' : 'Không hoạt động'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepositUstds::route('/'),
            'create' => Pages\CreateDepositUstd::route('/create'),
            'edit' => Pages\EditDepositUstd::route('/{record}/edit'),
        ];
    }
}
