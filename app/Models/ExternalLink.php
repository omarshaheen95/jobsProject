<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalLink extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'url_link', 'ordered'
    ];


}
