<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'display_name',
        'password_hash',
        'global_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function leadedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'leader_user_id', 'id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'user_id', 'id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'actor_id', 'id');
    }

    public function groupRole($teamId)
    {
        $teamMember = TeamMember::where('user_id', $this->id)->where('team_id', $teamId)->first();
        return $teamMember->role ?? 'guest';
    }

    public function getPasswordAttribute()
    {
        return $this->attributes['password_hash'];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }
}
