<?php

namespace App\Console\Commands;

use App\Jobs\GenerateArticleWithAI;
use Illuminate\Console\Command;

class GenerateArticleWithAICommand extends Command
{
    protected $signature = 'article:generate';
    protected $description = 'Generate a new article using OpenAI';

    public function handle()
    {
        $this->info('Dispatching article generation job...');
        GenerateArticleWithAI::dispatch();
        $this->info('Job dispatched successfully!');
    }
}
