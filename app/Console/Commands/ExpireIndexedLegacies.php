<?php

namespace App\Console\Commands;

use App\Models\Legacy;
use App\Notifications\IndexedStatusExpired;
use Illuminate\Console\Command;

class ExpireIndexedLegacies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legacies:expire-indexed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and mark indexed legacies as not-indexed if their expiration date has passed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired indexed legacies...');

        // Find legacies that are indexed and whose indexed expiration date is today or in the past.
        $expiredIndexed = Legacy::with('user')->where('is_indexed', true)
            ->whereDate('indexed_expires_at', '<=', now())
            ->get();

        if ($expiredIndexed->isEmpty()) {
            $this->info('No indexed legacies to de-index.');
            return 0;
        }

        $this->info("Found {$expiredIndexed->count()} indexed " . str('legacy')->plural($expiredIndexed->count()) . " to de-index...");

        foreach ($expiredIndexed as $legacy) {
            $legacy->is_indexed = false;
            $legacy->save();

            // Notify the user
            if ($legacy->user) {
                $legacy->user->notify(new IndexedStatusExpired($legacy));
                $this->line('  - De-indexed and notified user for: ' . $legacy->title);
            } else {
                $this->line('  - De-indexed: ' . $legacy->title);
            }
        }

        $this->info("Process complete. Successfully de-indexed {$expiredIndexed->count()} " . str('legacy')->plural($expiredIndexed->count()) . ".");

        return 0;
    }
}