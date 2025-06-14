<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\System\Menu;
use App\Models\System\Notification;
use App\Models\System\Role;
use App\Models\V1\Toko;
use App\Models\V1\UserEngineer;
use App\Models\V1\UserMstd;
use App\Models\V1\UserRndQuality;
use App\Traits\UUIDAsPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UUIDAsPrimaryKey;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'result'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'result' => 'array'
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user', 'email');
    }

    public function notify()
    {
        return $this->notifications()->where('status', 'unread')->orderBy('created_at', 'desc')->get();
    }

    public function tokoSaya()
    {
        return Toko::where('user_id', $this->id)->exists();
    }

    public function urlToko()
    {
        return Toko::where('user_id', $this->id)->first();
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role', 'name');
    }

    public function layout()
    {
        // Ambil semua menu terlebih dahulu
        return Menu::whereNull('parent_id') // Ambil menu utama
            ->with(['children' => function ($query) {
                $query->whereJsonContains(
                    'role',
                    $this->role
                ); // Ambil sub-menu sesuai jobTitle
            }])
            ->orderBy('order', 'DESC') // Urutkan menu utama
            ->get();
    }
}
