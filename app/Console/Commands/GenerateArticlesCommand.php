<?php

namespace App\Console\Commands;

use App\Jobs\GenerateArticle;
use Illuminate\Console\Command;

class GenerateArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 0; $i < 5; $i++) {
            GenerateArticle::dispatch();
        }
    }
}
