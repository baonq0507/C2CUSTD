<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellUstdResource\Pages;
use App\Filament\Resources\SellUstdResource\RelationManagers;
use App\Models\SellUstd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
class SellUstdResource extends Resource
{
    protected static ?string $model = SellUstd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Người dùng bán USDT';

    public static function getNavigationGroup(): ?string
    {
        return 'Mua bán';
    }

    public static function getLabel(): string
    {
        return 'Người dùng bán USDT';
    }

    public static function getNavigationBadge(): ?string
    {
        return parent::getEloquentQuery()->where('status', 'pending')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin người dùng')
                ->schema([
                    Select::make('user_id')->label('Tên người dùng')->relationship('user', 'username')->required(),
                    TextInput::make('amount')->label('Tổng bán ra USTD')->required(),
                    Select::make('status')->label('Trạng thái')->options([
                        'pending' => 'Đang bán',
                        'success' => 'Đã ngừng bán',
                    ])->default('pending'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')->label('Tên người dùng')->searchable()->sortable(),
                TextColumn::make('amount')->label('Tổng bán ra USTD')->sortable()->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.')),
                TextColumn::make('status')->label('Trạng thái')->sortable()->badge()->color(fn ($state) => $state === 'pending' ? 'warning' : 'danger')->formatStateUsing(fn ($state) => $state === 'pending' ? 'Đang bán' : 'Đã bán'),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Đang bán',
                    'approved' => 'Đã bán',
                ])->label('Trạng thái'),
                SelectFilter::make('user_id')->label('Tên người dùng')->relationship('user', 'username')->searchable()->preload(),
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
            'index' => Pages\ListSellUstds::route('/'),
            'create' => Pages\CreateSellUstd::route('/create'),
            'edit' => Pages\EditSellUstd::route('/{record}/edit'),
        ];
    }
}
