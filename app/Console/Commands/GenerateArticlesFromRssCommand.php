<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use SimpleXMLElement;
use App\Models\Article;

class GenerateArticlesFromRssCommand extends Command
{
    protected $signature = 'rss:generate-articles-rss';
    protected $description = 'Import articles from the New York Times World RSS feed';

    public function handle(): int
    {
        $feedCategories = [
//            'World',
//            'Americas',
//            'Europe',
//            'MiddleEast',
            'Education',
            'Politics',
            'Business',
            'Technology',
//            'Arts',
//            'ArtandDesign',
//            'Dance',
//            'Music',
//            'Movies',
//            'Television',
//            'Theater',
//            'SmallBusiness',
//            'EnergyEnvironment',
//            'Economy',
//            'Sports',
//            'Baseball',
//            'CollegeBasketball',
//            'CollegeFootball',
        ];

        foreach ($feedCategories as $feedCategory) {
            $url = 'https://rss.nytimes.com/services/xml/rss/nyt/'.$feedCategory.'.xml';

            $response = Http::get($url);

            if (! $response->ok()) {
                $this->error("Failed to fetch RSS feed.");
                return Command::FAILURE;
            }

            $xml = new SimpleXMLElement($response->body());

            foreach ($xml->channel->item as $item) {
                $title = (string) $item->title;
                $description = (string) $item->description;
                $author = (string) $item->children('dc', true)->creator;
                $categories = collect($item->xpath('category'))->map(fn($c) => (string) $c)->values()->toArray();

                if (empty($categories)) {
                    $this->line("Skipped no categories: $title");
                    continue;
                }

                if (Article::where('title', $title)->exists()) {
                    $this->line("Skipped duplicate: $title");
                    continue;
                }

                Article::create([
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'content' => $description,
                    'author' => $author,
                    'category' => $categories[0] ?? null,
                    'keywords' => array_slice($categories, 1),
                ]);

                $this->info("Imported: $title");
            }

        }

        return Command::SUCCESS;
    }
}
