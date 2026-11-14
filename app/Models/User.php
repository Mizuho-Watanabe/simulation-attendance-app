<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\AttendanceRecord;
use Carbon\Carbon;

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
     * このuserが持つattendance_recordsを取得
     */
    public function attendance_records()
    {
        return $this->hasMany(AttendanceRecord::class, 'user_id');
    }

    /**
     * admin_statusを取得
     */
    const STATUS_GENERAL = 0;
    const STATUS_ADMIN = 1;

    public function getAdminStatusAttribute(): string
    {
        $status = $this->attributes['admin_status'] ?? false;
        return $status ? '管理者' : '一般ユーザー';
    }

    /**
     * attendance_statusを取得
     */

    public function getAttendanceStatusAttribute()
    {
        $todayRecord = $this->attendance_records()
            ->whereDate('date', Carbon::today())
            ->first();

        $statusNum = $todayRecord ? $todayRecord->attendance_status : 0;

        return match ($statusNum) {
            0 => '勤務外',
            1 => '出勤中',
            2 => '休憩中',
            3 => '退勤済み',
                };
    }
}
