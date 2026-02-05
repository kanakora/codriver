<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;

class ProcessContentSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contents:process-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled publishing and expiration for content';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();
        $publishedCount = 0;
        $expiredCount = 0;

        Content::query()
            ->where('publish_status', 'draft')
            ->whereNotNull('scheduled_publish_at')
            ->where('scheduled_publish_at', '<=', $now)
            ->chunkById(100, function ($contents) use ($now, &$publishedCount) {
                foreach ($contents as $content) {
                    $content->update([
                        'publish_status' => 'published',
                        'published_at' => $content->published_at ?? $now,
                    ]);

                    $publishedCount++;
                }
            });

        Content::query()
            ->whereNull('archived_at')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $now)
            ->chunkById(100, function ($contents) use ($now, &$expiredCount) {
                foreach ($contents as $content) {
                    $content->update([
                        'archived_at' => $now,
                    ]);

                    $expiredCount++;
                }
            });

        $this->info("Published {$publishedCount} scheduled items.");
        $this->info("Archived {$expiredCount} expired items.");

        return self::SUCCESS;
    }
}
