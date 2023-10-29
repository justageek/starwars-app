<?php

namespace App\Models;

use App\Models\Planet;
use App\Models\Vehicle;
use App\Models\Starship;
use App\Models\BaseModel;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Film extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function characters()
    {
        return $this->morphedByMany(Character::class, 'filmable');
    }

    public function planets()
    {
        return $this->morphedByMany(Planet::class, 'filmable');
    }

    public function starships()
    {
        return $this->morphedByMany(Starship::class, 'filmable');
    }

    public function vehicles()
    {
        return $this->morphedByMany(Vehicle::class, 'filmable');
    }

    public function species()
    {
        return $this->morphedByMany(Species::class, 'filmable');
    }
}
