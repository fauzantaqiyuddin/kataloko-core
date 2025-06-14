<?php

namespace App\Models\System;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded;

    public function permission()
    {
        return $this->hasMany(Permission::class, 'role_id');
    }
}
