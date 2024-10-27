<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionDepositResource\Pages;
use App\Filament\Resources\TransactionDepositResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Models\User;
use Filament\Notifications\Notification;
class TransactionDepositResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): string
    {
        return 'Giao dịch nạp tiền';
    }

    //query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereIn('type', ['deposit', 'deposit_ustd'])->orderBy('id', 'desc');
    }

    public static function getNavigationBadge(): ?string
    {
        return Transaction::whereIn('type', ['deposit', 'deposit_ustd'])->where('status', 'pending')->count();
    }
    //group
    public static function getNavigationGroup(): ?string
    {
        return 'Giao dịch';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin giao dịch')->schema([
                    Select::make('user_id')->label('Người dùng')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                    TextInput::make('amount')->label('Số tiền'),
                    Select::make('type')->label('Loại giao dịch')
                    ->options([
                        'deposit' => 'Nạp tiền',
                        'deposit_ustd' => 'Nạp tiền USDT',
                    ]),
                    FileUpload::make('image')->label('Hình ảnh')->image()->previewable()->downloadable()->openable(true),

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Tên người dùng'),
                TextColumn::make('amount')->label('Số tiền')->formatStateUsing(fn(int $state): string => number_format($state , 0, ',', '.')),
                TextColumn::make('created_at')->label('Thời gian')->dateTime('d/m/Y H:i'),
                ImageColumn::make('image')->label('Hình ảnh'),
                TextColumn::make('status')->label('Trạng thái')->badge()->color(fn(string $state): string => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                })->formatStateUsing(fn(string $state): string => $state == 'pending' ? 'Chờ duyệt' : ($state == 'approved' ? 'Đã duyệt' : 'Đã từ chối')),
                TextColumn::make('updated_at')->label('Thời gian cập nhật')->dateTime('d/m/Y H:i'),
                TextColumn::make('created_at')->label('Thời gian tạo')->dateTime('d/m/Y H:i'),
                // type
                TextColumn::make('type')->label('Loại giao dịch')->formatStateUsing(fn(string $state): string => $state == 'deposit' ? 'Nạp tiền' : 'Nạp tiền USDT')
                ->badge()->color(fn(string $state): string => $state == 'deposit' ? 'success' : 'warning'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    //due
                    Tables\Actions\Action::make('Duyệt')
                        ->action(function(Transaction $record): void {
                            $record->update(['status' => 'approved']);
                            if($record->type == 'deposit_ustd') {
                                $record->user->update(['usdt_balance' => $record->user->usdt_balance + $record->amount]);
                            } else {
                                $record->user->update(['balance' => $record->user->balance + $record->amount]);
                            }
                            Notification::make()
                            ->title('Duyệt giao dịch')
                            ->body('Giao dịch đã được duyệt thành công')
                            ->success()
                            ->send();
                        })
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn(Transaction $record): bool => $record->status == 'pending'),
                    Tables\Actions\Action::make('Từ chối')->action(function(Transaction $record): void {
                        $record->update(['status' => 'rejected']);
                    })->icon('heroicon-o-x-circle')->color('danger')
                    ->visible(fn(Transaction $record): bool => $record->status == 'pending')
                    ->requiresConfirmation(),
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
            'index' => Pages\ListTransactionDeposits::route('/'),
            'create' => Pages\CreateTransactionDeposit::route('/create'),
            'edit' => Pages\EditTransactionDeposit::route('/{record}/edit'),
        ];
    }
}
