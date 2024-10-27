<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    //label
    public static function getLabel(): string
    {
        return 'Người dùng';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin người dùng')
                ->schema([
                    TextInput::make('username')->label('Biệt hiệu')->unique(ignoreRecord: true)->required(),
                    TextInput::make('email')->label('Email')->unique(ignoreRecord: true)->required(),
                    Select::make('role')->options([
                        'admin' => 'Quản trị',
                        'user' => 'Người dùng',
                    ])->label('Quyền'),
                    TextInput::make('password')->label('Mật khẩu')->password()
                    ->required( fn(User $user) => is_null($user->id))->visible(fn(User $user) => is_null($user->id)),
                    TextInput::make('balance')->label('Số dư VNĐ'),
                    TextInput::make('usdt_balance')->label('Số dư USDT'),
                    TextInput::make('referral_code')->label('Mã giới thiệu')->required(),
                    TextInput::make('total_withdraw')->label('Tổng rút tiền')->visible(fn(User $user) => !is_null($user->id)),
                    TextInput::make('total_deposit')->label('Tổng nạp tiền')->visible(fn(User $user) => !is_null($user->id)),
                    //level
                    Select::make('level')->options([
                        1 => 'Hạng thường',
                        2 => 'Hạng thương gia',
                        3 => 'Hạng vàng',
                        4 => 'Hạng bạc',
                        5 => 'Hạng kim cương',
                    ])->label('Level'),
                ])->columns(2),

                Section::make('Thông tin liên hệ')
                ->schema([
                    TextInput::make('phone')->label('Số điện thoại'),
                    TextInput::make('bank_name')->label('Tên ngân hàng'),
                    TextInput::make('bank_account')->label('Số tài khoản'),
                    TextInput::make('bank_owner')->label('Chủ tài khoản'),
                    Toggle::make('accept_info')->label('Duyệt thông tin'),
                ])->columns(2)
                ->hidden(fn(User $user) => is_null($user->id)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')->label('Biệt hiệu'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('role')->badge()->color(fn ($state) => match ($state) {
                    'admin' => 'success',
                    'user' => 'warning',
                })->label('Quyền')
                ->formatStateUsing(fn ($state) => $state == 'admin' ? 'Quản trị' : 'Người dùng'),
                //balance
                TextColumn::make('balance')->label('Số dư')->money('VND'),
                TextColumn::make('usdt_balance')->label('Số dư USDT')->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.')),
                //level
                TextColumn::make('level')->label('Level')->formatStateUsing(fn ($state) => $state == 1 ? 'Hạng thường' : ($state == 2 ? 'Hạng thương gia' : ($state == 3 ? 'Hạng vàng' : ($state == 4 ? 'Hạng bạc' : 'Hạng kim cương'))))->badge()->color(fn ($state) => match ($state) {
                    1 => 'warning',
                    2 => 'success',
                    3 => 'danger',
                    4 => 'info',
                    5 => 'primary',
                }),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('balance')->label('Cộng số dư VNĐ')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\TextInput::make('balance')->label('Số dư VNĐ')
                    ])->modalWidth('sm')->modalHeading('Cộng số dư VNĐ')
                    ->action(function ($data, $record) {
                        $record->balance += $data['balance'];
                        $record->save();
                        Notification::make()->title('Cộng số dư VNĐ thành công')->success()->send();
                    }),
                    //usdt_balance
                    Tables\Actions\Action::make('usdt_balance')->label('Cộng số dư USDT')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\TextInput::make('usdt_balance')->label('Số dư USDT')
                    ])->modalWidth('sm')->modalHeading('Cộng số dư USDT')
                    ->action(function ($data, $record) {
                        $record->usdt_balance += $data['usdt_balance'];
                        $record->save();
                        Notification::make()->title('Cộng số dư USDT thành công')->success()->send();
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
