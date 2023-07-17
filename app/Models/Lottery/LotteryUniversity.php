<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LotteryUniversity extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'active'
    ];
}
