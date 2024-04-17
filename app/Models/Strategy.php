<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    use HasFactory;

    protected $table = 'strategy';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function metricHistoryRun()
    {
        return $this->hasOne(MetricHistoryRun::class);
    }
}
