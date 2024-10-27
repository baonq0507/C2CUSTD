<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'referral_code' => 'admin',
            'balance' => 0,
            'usdt_balance' => 0,
            'usdt_total_withdraw' => 0,
            'usdt_total_deposit' => 0,
            'level' => 1,
            'status' => 'active',
            'bank_account' => '1234567890',
            'bank_name' => 'Vietcombank',
            'bank_branch' => 'Hà Nội',
            'bank_owner' => 'Nguyễn Văn A',
            'username' => 'admin',
        ]);

        $this->call([
            DepositUstdSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
