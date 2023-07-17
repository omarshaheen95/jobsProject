<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExcelFile extends Model
{
    use SoftDeletes;
    //'New', 'Uploading', 'Completed', 'Failed'
    //type = 'grades', 'applicants'
    protected $fillable = [
        'file', 'file_name', 'type', 'created_rows', 'updated_rows', 'progress_status', 'log_errors'
    ];

    protected $casts = [
        'log_errors' => 'array',
    ];

    public function getProgressStatusErrorAttribute()
    {
        $status = $this->progress_status;
        if (!is_null($this->log_errors) &&  count($this->log_errors)) {
            $status .= ' ' . t('with errors');
        }

        return $status;
    }

    public function getTextClassAttribute()
    {
        switch($this->progress_status)
        {
            case 'New':
                return 'text-info';
            case 'Uploading':
                return 'text-danger';
            case 'Completed':
                if (count($this->log_errors))
                {
                    return 'text-danger';
                }else{
                    return 'text-success';
                }

            case 'Failed':
                return 'text-warning';
            default :
                return '';
        }
    }
}
