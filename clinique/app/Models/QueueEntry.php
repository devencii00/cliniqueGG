<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueueEntry extends Model
{
    protected $table = 'queues';
    protected $fillable = [
        'user_id',
        'status',
        'queue_number',
        'window_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}