<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

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
    public function break_times(): hasMany
    {
        return $this->hasMany(BreakTime::class);
    }

    /**
     * このattendance_recordが持つapplicationを取得
     */
    public function applications(): hasMany
    {
        return $this->hasMany(Application::class);
    }

}
