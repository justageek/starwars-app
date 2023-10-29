<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeApiUrl($query, $url)
    {
        return $query->where('api_url', $url);
    }
}