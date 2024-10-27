<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuyUstdResource\Pages;
use App\Filament\Resources\BuyUstdResource\RelationManagers;
use App\Models\BuyUstd;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class BuyUstdResource extends Resource
{
    protected static ?string $model = BuyUstd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Người dùng mua USDT';

    public static function getNavigationGroup(): ?string
    {
        return 'Mua bán';
    }
    public static function getLabel(): string
    {
        return 'Người dùng mua USDT';
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
                    TextInput::make('price_buy')->label('Giá mua vào VNĐ')->required(),
                    TextInput::make('total_buy')->label('Tổng mua vào USTD')->required(),
                    TextInput::make('min_limit_buy')->label('Giới hạn nhỏ nhất')->required(),
                    TextInput::make('max_limit_buy')->label('Giới hạn lớn nhất')->required(),
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
                TextColumn::make('price_buy')->label('Giá mua vào VNĐ')->money('VND')->sortable(),
                TextColumn::make('total_buy')->label('Tổng mua vào USTD')->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.')),
                TextColumn::make('remaining_buy')->label('Còn lại')->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))->sortable(),
                TextColumn::make('min_limit_buy')->label('Giới hạn nhỏ nhất')->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))->sortable(),
                TextColumn::make('max_limit_buy')->label('Giới hạn lớn nhất')->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))->sortable(),
                TextColumn::make('status')->label('Trạng thái')->badge()->color(fn ($state) => $state === 'pending' ? 'warning' : 'danger')->formatStateUsing(fn ($state) => $state === 'pending' ? 'Đang mua' : 'Đã ngừng mua'),
            ])
            ->filters([
                SelectFilter::make('user_id')->label('Tên người dùng')->relationship('user', 'username')->multiple()->preload()->searchable(),
                SelectFilter::make('status')->label('Trạng thái')->options([
                    'pending' => 'Đang bán',
                    'approved' => 'Đã ngừng mua',
                ])->multiple(),
                // SelectFilter::make('created_at')->label('Ngày tạo')->date(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListBuyUstds::route('/'),
            'create' => Pages\CreateBuyUstd::route('/create'),
            'edit' => Pages\EditBuyUstd::route('/{record}/edit'),
        ];
    }
}
