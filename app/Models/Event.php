<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'start_datetime' => 'datetime:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'name',
        'description',
        'event_type',
        'start_datetime',
        'location',
        'created_at',
        'updated_at',
    ];

    public function getStartDatetimeAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type', 'id');
    }

}
