<?php

namespace App\Console\Commands;

use App\Jobs\GenerateArticleWithAI;
use Illuminate\Console\Command;

class GenerateArticlesWithAICommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-articles-ai';

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
            GenerateArticleWithAI::dispatch();
        }
    }
}
