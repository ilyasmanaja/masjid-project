<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'routine_day',
        'speaker',
        'event_date',
        'location',
        'poster',
        'description',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];
}