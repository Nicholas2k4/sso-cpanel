<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Resource extends Model
{
    //
    protected $fillable = [
        'type',
        'name',
        'resource_data',
    ];

    public function teams(): BelongsToMany{
        return $this->belongsToMany(Team::class, 'team_resources');
    }
}
