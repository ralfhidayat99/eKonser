<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'concert_id',
        'ticket_type_id',
        'user_id',
        'unique_code',
        'used',
        'redeemed_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'redeemed_at' => 'datetime',
    ];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }
}
