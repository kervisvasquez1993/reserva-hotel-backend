<?php

namespace App\Jobs;


use App\Models\InmuebleCode; 
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteExpiredCodeJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inmuebleCode;

    public function __construct(InmuebleCode $inmuebleCode)
    {
        $this->inmuebleCode = $inmuebleCode;
    }

    public function handle()
    {
        if ($this->inmuebleCode->created_at->lt(Carbon::now()->subMinutes(3))) {
            $this->inmuebleCode->delete();
        }
    }
}
