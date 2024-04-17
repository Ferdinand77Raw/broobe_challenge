<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricHistoryRun extends Model
{
    use HasFactory;

    protected $table = 'metric_history_run';

    protected $fillable = [
        'url',
        'performance_metric',
        'accesibility_metric',
        'best_practices_metric',
        'seo_metric',
        'pwa_metric',
        'strategy_id',
    ];

    protected $attributes = [
        'performance_metric' => 0, 
        'accesibility_metric' => 0,
        'best_practices_metric' => 0, 
        'seo_metric' => 0, 
        'pwa_metric' => 0, 
    ];
    

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }
}
