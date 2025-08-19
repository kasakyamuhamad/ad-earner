<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessPayouts extends Command
{
    // app/Console/Commands/ProcessPayouts.php
protected $signature = 'payouts:process';

public function handle()
{
    $pending = Withdrawal::where('status', 'pending')->get();
    
    foreach ($pending as $withdrawal) {
        // Call Flutterwave API
        // Update status if successful
    }
}
}
