<?php

namespace App\Console\Commands;

use App\Jobs\GenerateArticle;
use Illuminate\Console\Command;

class GenerateArticleCommand extends Command
{
    protected $signature = 'article:generate';
    protected $description = 'Generate a new article using OpenAI';

    public function handle()
    {
        $this->info('Dispatching article generation job...');
        GenerateArticle::dispatch();
        $this->info('Job dispatched successfully!');
    }
}
