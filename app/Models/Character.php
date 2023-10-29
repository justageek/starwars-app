<?php

namespace App\Models;

use App\Models\Film;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Character extends BaseModel
{
    use HasFactory;

    public function films()
    {
        return $this->morphToMany(Film::class, 'filmable');
    }
}
