<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestasi;
use App\Models\Legacy;
use Illuminate\Support\Facades\DB;

class MigratePrestasiToLegacies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-prestasi-to-legacies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates data from the old `prestasi` table to the new `legacies` table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration from `prestasi` to `legacies` table.');

        // Use a transaction to ensure data integrity
        DB::transaction(function () {
            // Disable mass assignment guard for Legacy model temporarily
            Legacy::unguard();

            $prestasiRecords = Prestasi::all();
            $bar = $this->output->createProgressBar(count($prestasiRecords));

            foreach ($prestasiRecords as $prestasi) {
                $status = ($prestasi->payment_status === 'paid' && $prestasi->status_prestasi === 'aktif') ? 'active' : 'pending';
                $isIndexed = ($prestasi->status_rekomendasi === 'Diterima' || $prestasi->badge === 1);

                Legacy::create([
                    'id'             => $prestasi->prestasi_id, // Keep the same ID if possible
                    'user_id'        => $prestasi->user_id,
                    'title'          => $prestasi->judul_prestasi,
                    'description'    => null, // No source for description
                    'photo'          => $prestasi->foto_sertifikat,
                    'status'         => $status,
                    'is_indexed'     => $isIndexed,
                    'published_at'   => ($status === 'active') ? $prestasi->updated_at : null,
                    'created_at'     => $prestasi->created_at,
                    'updated_at'     => $prestasi->updated_at,
                ]);

                $bar->advance();
            }

            // Re-enable mass assignment guard
            Legacy::reguard();

            $bar->finish();
            $this->info("\nMigration completed successfully. " . count($prestasiRecords) . " records migrated.");
        });

        return 0;
    }
}
