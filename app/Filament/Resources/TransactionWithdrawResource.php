<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionWithdrawResource\Pages;
use App\Filament\Resources\TransactionWithdrawResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionWithdrawResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return Transaction::where('type','withdraw')->where('status', 'pending')->count();
    }
    //group
    //query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'withdraw')->orderBy('id', 'desc');
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Giao dịch';
    }
    //label
    public static function getLabel(): string
    {
        return 'Giao dịch rút tiền';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //user
                Forms\Components\Select::make('user_id')
                    ->label('Tên người dùng')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('amount')
                    ->label('Số tiền')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ duyệt',
                        'approved' => 'Đã duyệt',
                        'rejected' => 'Đã từ chối',
                    ]),
                Forms\Components\Select::make('type')
                    ->label('Loại giao dịch')
                    ->options([
                        'withdraw' => 'Rút tiền',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Tên người dùng'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Số tiền')
                    ->money('VND'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn($state) => $state == 'pending' ? 'Chờ duyệt' : ($state == 'approved' ? 'Đã duyệt' : 'Đã từ chối'))
                    ->label('Trạng thái'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Thời gian')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('approve')
                        ->label('Duyệt')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn($record) => $record->update(['status' => 'approved']))
                        ->visible(fn($record) => $record->status == 'pending'),
                    Tables\Actions\Action::make('reject')
                        ->label('Từ chối')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(fn($record) => $record->update(['status' => 'rejected']))
                        ->visible(fn($record) => $record->status == 'pending'),
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
            'index' => Pages\ListTransactionWithdraws::route('/'),
            'create' => Pages\CreateTransactionWithdraw::route('/create'),
            'edit' => Pages\EditTransactionWithdraw::route('/{record}/edit'),
        ];
    }
}
