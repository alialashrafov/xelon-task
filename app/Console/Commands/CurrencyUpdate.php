<?php

namespace App\Console\Commands;

use App\Jobs\CurrencyUpdate as CurrencyUpdateJob;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;

class CurrencyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just do it only once';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return app(Dispatcher::class)->dispatch(new CurrencyUpdateJob());
    }
}
