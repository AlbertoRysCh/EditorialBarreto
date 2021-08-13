<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TelescopePrune extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminara todas las entradas a telescope que tengan más de 48 horas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Artisan::call('telescope:prune --hours=48');
        Artisan::call('telescope:prune --hours=24');
        $this->info('Todas las entradas a telescope que tengan más de 48 horas fueron eliminadas.');
    }
}
