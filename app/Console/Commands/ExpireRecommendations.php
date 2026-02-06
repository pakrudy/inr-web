<?php

namespace App\Console\Commands;

use App\Models\Recommendation;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ExpireRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and mark active recommendations as expired if their expiration date has passed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired recommendations (R1)...');

        // Find recommendations that are active and whose expiration date is today or in the past.
        $expiredRecommendations = Recommendation::with('user')
            ->where('status', 'active')
            ->whereDate('expires_at', '<=', now())
            ->get();

        if ($expiredRecommendations->isEmpty()) {
            $this->info('No recommendations to expire.');
        } else {
            $this->info("Found {$expiredRecommendations->count()} recommendation(s) to expire...");

            foreach ($expiredRecommendations as $recommendation) {
                $recommendation->status = 'expired';
                $recommendation->save();

                // Notify the user
                $recommendation->user->notify(new \App\Notifications\RecommendationExpired($recommendation));
                $this->line('  - Expired and notified for: ' . $recommendation->place_name);
            }

            $this->info("Process complete. Successfully marked {$expiredRecommendations->count()} recommendation(s) as expired and notified users.");
        }
        
        $this->info('---');

        $this->info('Checking for expired indexed recommendations (R2)...');

        // Find recommendations that are indexed and whose indexed expiration date is today or in the past.
        $expiredIndexed = Recommendation::with('user')->where('is_indexed', true)
            ->whereDate('indexed_expires_at', '<=', now())
            ->get();

        if ($expiredIndexed->isEmpty()) {
            $this->info('No indexed recommendations to de-index.');
            return 0;
        }

        $this->info("Found {$expiredIndexed->count()} indexed recommendation(s) to de-index...");

        foreach ($expiredIndexed as $recommendation) {
            $recommendation->is_indexed = false;
            $recommendation->save();
            
            if ($recommendation->user) {
                $recommendation->user->notify(new \App\Notifications\IndexedRecommendationStatusExpired($recommendation));
                $this->line('  - De-indexed and notified user for: ' . $recommendation->place_name);
            } else {
                $this->line('  - De-indexed: ' . $recommendation->place_name);
            }
        }

        $this->info("Process complete. Successfully de-indexed {$expiredIndexed->count()} recommendation(s).");

        return 0;
    }
}
