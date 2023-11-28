<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = [
        'event_type',
        'created_at',
        'updated_at',
    ];
    use HasFactory;

    public function events()
    {
        return $this->hasMany(Event::class, 'event_type', 'id');
    }

}
