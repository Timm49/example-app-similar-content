<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Timm49\SimilarContentLaravel\SimilarContentContext;

class ShowTopSimilarArticles extends Command
{
    protected $signature = 'similar-content:top-matches {--limit=10}';
    protected $description = 'Show top N most similar articles based on embeddings';

    public function handle(): int
    {
        $embeddingItems = DB::table('embeddings')
            ->where('embeddable_type', Article::class)
            ->get();

        $results = [];
        $count = count($embeddingItems);

        for ($i = 0; $i < $count; $i++) {
            $a = $embeddingItems[$i];
            $vectorA = json_decode($a->data, true);

            for ($j = $i + 1; $j < $count; $j++) {
                $b = $embeddingItems[$j];
                $vectorB = json_decode($b->data, true);

                $score = $this->calculateCosineSimilarity($vectorA, $vectorB);

                $results[] = [
                    'a_id' => $a->embeddable_id,
                    'b_id' => $b->embeddable_id,
                    'score' => $score,
                ];
            }
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        $topResults = array_slice($results, 0, 10);

        foreach ($topResults as $match) {
            $this->line("{$match['a_id']} <-> {$match['b_id']} = {$match['score']}");
        }

        return Command::SUCCESS;
    }

    private function calculateCosineSimilarity(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        for ($i = 0; $i < count($vectorA); $i++) {
            $dotProduct += $vectorA[$i] * $vectorB[$i];
            $magnitudeA += $vectorA[$i] * $vectorA[$i];
            $magnitudeB += $vectorB[$i] * $vectorB[$i];
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        if ($magnitudeA === 0 || $magnitudeB === 0) {
            return 0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }
}
