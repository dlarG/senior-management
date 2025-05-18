<?php

namespace App\Console\Commands;

use App\Models\Program;
use Illuminate\Console\Command;

class UpdateProgramStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-program-status';

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
        $now = now();
    
        Program::whereHas('start_date', function($query) use ($now) {
            $query->whereDate('start_date', '<=', $now)
                ->whereTime('end_time', '<', $now->format('H:i:s'));
        })->update(['status' => 'inactive']);

        $this->info('Program statuses updated successfully.');
        }
}
