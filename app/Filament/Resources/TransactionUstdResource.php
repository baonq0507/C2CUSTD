<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionUstdResource\Pages;
use App\Filament\Resources\TransactionUstdResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Section;
class TransactionUstdResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationBadge(): ?string
    {
        return Transaction::whereIn('type', ['sell_usdt', 'buy_usdt'])->where('status', 'pending')->count();
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereIn('type', ['sell_usdt', 'buy_usdt'])->orderBy('id', 'desc');
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Giao dịch';
    }
    //label
    public static function getLabel(): string
    {
        return 'Giao dịch USDT';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin giao dịch')->schema([
                    Forms\Components\Select::make('user_id')
                    ->label('Người dùng')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                    Forms\Components\TextInput::make('amount')
                    ->label('Số USTD'),
                    Forms\Components\Select::make('type')
                    ->label('Loại giao dịch')
                    ->options([
                        'buy_usdt' => 'Mua',
                        'sell_usdt' => 'Bán',
                    ]),
                    Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'approved' => 'Đã duyệt',
                        'pending' => 'Chờ duyệt',
                    ]),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Tên người dùng'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Số USTD'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => $state == 'approved' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == 'approved' ? 'Đã duyệt' : 'Chờ duyệt')
                    ->label('Trạng thái'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Loại giao dịch')
                    ->badge()
                    ->color(fn($state) => $state == 'buy_usdt' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state == 'buy_usdt' ? 'Mua' : 'Bán')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Thời gian')
                    ->sortable()
                    ->dateTime('d/m/Y H:i'),

            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Tên người dùng')
                    ->relationship('user', 'name')
                    ->searchable(),
                SelectFilter::make('type')
                    ->label('Loại giao dịch')
                    ->options([
                        'buy_usdt' => 'Mua',
                        'sell_usdt' => 'Bán',
                    ]),
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'approved' => 'Đã duyệt',
                        'pending' => 'Chờ duyệt',
                        'canceled' => 'Đã hủy',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
            'index' => Pages\ListTransactionUstds::route('/'),
            'create' => Pages\CreateTransactionUstd::route('/create'),
            'edit' => Pages\EditTransactionUstd::route('/{record}/edit'),
        ];
    }
}
