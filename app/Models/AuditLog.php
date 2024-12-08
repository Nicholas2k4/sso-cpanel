<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    //
    protected $fillable = [
        'event_type',
        'team_id',
        'actor_id',
        'object_type',
        'object_id',
        'action',
        'description',
    ];

    public function team(): BelongsTo{
        return $this->belongsTo(Team::class);
    }
    public function actor(): BelongsTo{
        return $this->belongsTo(User::class, 'actor_id', 'id');
    }
}
