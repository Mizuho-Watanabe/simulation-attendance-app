<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * 代入不可能な属性
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'admin_status',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * このuserが持つattendanceを取得
     */
    public function attendances(): BelongsToMany
    {
        return $this->belongsToMany(Attendance::class);
    }

    /**
     * admin_statusを取得
     */
    const STATUS_GENERAL = 0;
    const STATUS_ADMIN = 1;

    public function getAdminStatusAttribute(): string
    {
        return $this->admin_status ? '管理者' : '一般ユーザー';
    }
}
