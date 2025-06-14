<?php

namespace App\Models\V1;

use App\Models\System\StatusApproval;
use App\Models\User;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnePointLesson extends Model
{
    use HasFactory, UUIDAsPrimaryKey, SoftDeletes;
    protected $guarded;

    protected $casts = [
        'distribusi' => 'array',
    ];

    public function mesin()
    {
        return $this->belongsTo(Machine::class, 'mesin_id', 'id');
    }

    public function lampiran()
    {
        return $this->hasMany(ImageOpl::class, 'opl_id', 'id');
    }

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'user', 'email');
    }
    public function kategori()
    {
        return $this->belongsTo(CategoryUmum::class, 'category_umum_id', 'id');
    }
    public function kategoriRnd()
    {
        return $this->belongsTo(CategoryRnd::class, 'category_rnd_id', 'id');
    }

    public function approval()
    {
        return $this->belongsTo(StatusApproval::class, 'progress', 'code');
    }

    public function firstImage()
    {
        return $this->hasOne(ImageOpl::class, 'opl_id', 'id')->orderBy('created_at')->limit(1);
    }

    public function firstSosialisasi()
    {
        return $this->hasOne(Sosialisasi::class, 'opl_id', 'id')
            ->where('user', auth()->user()->email)
            ->orderBy('created_at')->limit(1);
    }

    public function sosialisasi()
    {
        return $this->hasMany(Sosialisasi::class, 'opl_id', 'id');
    }

    public function sosialisasiPublish()
    {
        return $this->hasMany(Sosialisasi::class, 'opl_id', 'id')
            ->where('status', 'aprove');
    }
}
