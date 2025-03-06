<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'position',
        'team',
        'team_id',
        'height',
        'weight',
        'appearance',
        'speed',
        'strength',
        'agility',
        'stamina',
        'tackling',
        'kicking',
        'passing',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'appearance' => 'array',
        'height' => 'integer',
        'weight' => 'integer',
        'speed' => 'integer',
        'strength' => 'integer',
        'agility' => 'integer',
        'stamina' => 'integer',
        'tackling' => 'integer',
        'kicking' => 'integer',
        'passing' => 'integer',
    ];

    /**
     * Get the user that owns the player.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the team that the player belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Check if the player is eligible to play (must be on a team).
     */
    public function isEligibleToPlay()
    {
        return !is_null($this->team_id);
    }
}
