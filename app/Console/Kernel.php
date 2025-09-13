// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('payouts:process')->hourly();
}
// app/Http/Middleware/AdminMiddleware.php
 protected $routeMiddleware = [
        // ...
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];      