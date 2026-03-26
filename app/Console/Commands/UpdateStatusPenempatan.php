<?php

namespace App\Console\Commands;

use App\Models\penempatan;
use Illuminate\Console\Command;

class UpdateStatusPenempatan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-status-penempatan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $penempatan = penempatan::where('status', 'aktif')
            ->whereDate('tgl_selesai', '<', now())
            ->get();

        foreach ($penempatan as $item) {
            $item->update(['status' => 'selesai']);
        }

        return 0;
    }
}
