<?php

namespace App\Jobs;

use App\Imports\GradeImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GradeImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $req;
    public function __construct(Request $request)
    {
        $this->req = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $import = new GradeImport();
        $import->import($this->req->file('file'));
        Log::alert($import->getLogErrors());
        Log::notice($import->getCreatedRows());
        Log::info($import->getUpdatedRows());
    }
}
