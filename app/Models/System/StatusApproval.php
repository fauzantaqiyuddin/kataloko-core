<?php

namespace App\Models\System;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusApproval extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded;
}
