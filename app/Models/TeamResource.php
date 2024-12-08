<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamResource extends Model
{
    protected $fillable = [
        'team_id',
        'resource_id',
    ];

    public function team(): BelongsTo{
        return $this->belongsTo(Team::class);
    }
    public function resource(): BelongsTo{
        return $this->belongsTo(Resource::class);
    }
}
