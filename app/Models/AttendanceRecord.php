<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttendanceRecord extends Model
{
    use HasFactory;

    /**
     * 代入可能な属性
     *
     * @var array<int,datetime, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'total_break_time',
        'total_time',
        'attendance_status',
    ];

    /**
     * このattendance_recordが属するuserを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このattendance_recordが持つbreak_timeを取得
     */
    public function break_times(): BelongsToMany
    {
        return $this->belongsToMany(Break_time::class);
    }

    /**
     * このattendance_recordが持つapplicationを取得
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }

    /**
     * attendance_statusを取得
     */
    const STATUS_OFF = 0;
    const STATUS_WORKING = 1;
    const STATUS_BREAKING = 2;
    const STATUS_FINISHED = 3;

    public function getAttendanceStatusAttribute(): string
    {
        return match($this->attendance_status) {
            self::STATUS_OFF => '勤務外',
            self::STATUS_WORKING => '勤務中',
            self::STATUS_BREAKING => '休憩中',
            self::STATUS_FINISHED => '退勤済み',
        };
    }
}
