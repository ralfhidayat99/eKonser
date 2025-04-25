<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'date',
        'location',
        'banner',
        'quota',
        'price',
        'kategori',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }
}
