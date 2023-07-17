<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LotteryDegree extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'active'
    ];
}
