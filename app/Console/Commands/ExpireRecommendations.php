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
        $this->info('Checking for expired recommendations...');

        $expiredCount = Recommendation::where('status', 'active')
            ->where('expires_at', '<', Carbon::now())
            ->update(['status' => 'expired']);

        if ($expiredCount > 0) {
            $this->info("Successfully marked {$expiredCount} recommendation(s) as expired.");
        } else {
            $this->info('No recommendations to expire.');
        }

        return 0;
    }
}
