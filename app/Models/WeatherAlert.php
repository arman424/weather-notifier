<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherAlert extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'city', 'alert_type', 'alert_data', 'notified', 'notified_at'];

    public $timestamps = true;

    protected $casts = [
        'alert_data' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
