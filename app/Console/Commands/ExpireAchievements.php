<?php

namespace App\Console\Commands;

use App\Models\Prestasi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireAchievements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'achievements:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for active achievements that have passed their expiration date and mark them as expired.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired achievements...');

        $expiredAchievements = Prestasi::where('status_prestasi', 'aktif')
            ->where('expired_at', '<=', now())
            ->get();

        if ($expiredAchievements->isEmpty()) {
            $this->info('No achievements to expire.');
            return 0;
        }

        $count = $expiredAchievements->count();
        $this->info("Found {$count} achievements to expire.");

        foreach ($expiredAchievements as $achievement) {
            $achievement->status_prestasi = 'expired';
            $achievement->payment_status = 'expired';
            $achievement->save();
        }

        $message = "Successfully expired {$count} achievements.";
        $this->info($message);
        Log::info($message); // Also log to the default log file

        return 0;
    }
}