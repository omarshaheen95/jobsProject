<?php

namespace App\Jobs;

use App\Imports\ApplicantImport;
use App\Imports\GradeImport;
use App\Models\ExcelFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportExcelFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $excelFile;
    public function __construct(ExcelFile $excelFile)
    {
        $this->excelFile = $excelFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            $this->excelFile->update([
                'progress_status' => 'Uploading',
            ]);
            if ($this->excelFile->type == 'grades')
            {
                $import = new GradeImport();
            }else{
                $import = new ApplicantImport();
            }

            $import->import(public_path($this->excelFile->file));
            $this->excelFile->update([
                'created_rows' => $import->getUpdatedRows(),
                'updated_rows' => $import->getUpdatedRows(),
                'log_errors' => $import->getLogErrors(),
                'progress_status' => 'Completed',
            ]);
        }catch (\Exception $e)
        {
            $this->excelFile->update([
                'log_errors' => [$e->getMessage()],
                'progress_status' => 'Failed',
            ]);
        }
    }
}
