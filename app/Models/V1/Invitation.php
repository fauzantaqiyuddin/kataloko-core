<?php

namespace App\Models\V1;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded;

    public function opl()
    {
        return $this->belongsTo(OnePointLesson::class, 'opl_id', 'id');
    }
}
