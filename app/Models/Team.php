<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    //
    protected $fillable = [
        'name',
        'logo_link',
        'leader_user_id',
    ];

    public function leader(): BelongsTo{
        return $this->belongsTo(User::class, 'leader_user_id', 'id');
    }

    public function members(): HasMany{
        return $this->hasMany(TeamMember::class, 'team_id', 'id');
    }

    public function auditLogs(): HasMany{
        return $this->hasMany(AuditLog::class);
    }

    public function resources(): BelongsToMany{
        return $this->belongsToMany(Resource::class, 'team_resources');
    }
}
