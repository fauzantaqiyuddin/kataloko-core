<?php

namespace App\Models\System;

use App\Models\V1\Company;
use App\Traits\AuditTrailable;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, UUIDAsPrimaryKey;
    protected $guarded;

    public function company()
    {
        return $this->belongsTo(Company::class, 'compCode', 'compCode');
    }
}
