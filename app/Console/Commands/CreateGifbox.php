<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Gifbox;
class CreateGifbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-gifbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo gifbox mặc định';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //random amount
        $amount = [
            3,5,10,20,50
        ];
        $randomAmount = $amount[array_rand($amount)];
        Gifbox::create([
            'name' => 'X' . $randomAmount . '%' . ' Số dư hiện tại',
            'amount' => $randomAmount
        ]);
    }
}
