<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InmuebleCode;
use Carbon\Carbon;

class DeleteExpiredCodes extends Command
{
    protected $signature = 'codes:deleteexpired';

    protected $description = 'Delete expired codes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    \Log::info('Comando codes:deleteexpired ejecutado. Número de códigos eliminados: ');
    $expiredTime = Carbon::now()->subMinutes(3);
    $deletedCount = InmuebleCode::where('created_at', '<', $expiredTime)->delete();

    
}
}