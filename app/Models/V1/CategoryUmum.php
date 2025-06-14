<?php

namespace App\Models\V1;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryUmum extends Model
{
    use HasFactory, UUIDAsPrimaryKey, SoftDeletes;
    protected $guarded;
}
