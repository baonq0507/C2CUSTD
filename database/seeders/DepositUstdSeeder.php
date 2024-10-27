<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DepositUstd;
class DepositUstdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['USDT(TRC20)', 'USDT(ERC20)', 'USDT(BEP20)', 'USDT(OMNI)', 'USDT(TRON)', 'BTC', 'ETH', 'XRP', 'LTC', 'SOL', 'DOGE', 'BCH', 'DOT', 'BNB', 'ADA', 'XLM', 'LINK', 'UNI', 'BTC', 'ETH', 'XRP', 'LTC', 'SOL', 'DOGE', 'BCH', 'DOT', 'LINK', 'UNI'];
        foreach ($types as $type) {
            DepositUstd::create([
                'type' => $type,
                'address' => '0x1234567890abcdef',
                'status' => 'active',
            ]);
        }
    }
}
