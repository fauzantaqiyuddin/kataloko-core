<?php
namespace App\Models\MasterData;

use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPackage extends Model
{
    use HasFactory, UUIDAsPrimaryKey;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'price',
        'isTrial',
        'access',
    ];

    protected $casts = [
        'price'   => 'decimal:2',
        'isTrial' => 'boolean',
        'access'  => 'array',
    ];
}
