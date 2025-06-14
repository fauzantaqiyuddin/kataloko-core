<?php

namespace App\Models\System;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded;

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
