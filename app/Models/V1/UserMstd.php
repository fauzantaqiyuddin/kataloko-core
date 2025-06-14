<?php

namespace App\Models\V1;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMstd extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded;

    public function company()
    {
        return $this->belongsTo(Company::class, 'compCode', 'compCode');
    }
}
