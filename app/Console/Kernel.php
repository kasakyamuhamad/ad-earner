// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('payouts:process')->hourly();
}