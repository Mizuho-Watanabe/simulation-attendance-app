<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Application extends Model
{
    use HasFactory;

    /**
     * 代入可能な属性
     *
     * @var array<int,datetime, string>
     */
    protected $fillable = [
        'attendance_record_id',
        'new_date',
        'new_clock_in',
        'new_clock_out',
        'approval_status',
        'comment',
    ];

    /**
     * このapplicationが属するattendance_recordを取得
     */
    public function attendance_record(): BelongsTo
    {
        return $this->belongsTo(AttendanceRecord::class);
    }

    /**
     * このapplicationが持つnew_break_timeを取得
     */
    public function new_break_times(): hasMany
    {
        return $this->hasMany(NewBreakTime::class);
    }

    /**
     * approval_statusを取得
     */
    const STATUS_PEND_APPROVAL = 0;
    const STATUS_APPROVED = 1;

    public function getApprovalStatusAttribute(): string
    {
        $status = $this->attributes['approval_status'] ?? false;
        return $status ? '承認済み' : '承認待ち';
    }

    /**
     * user_nameを取得
     */
    public function getUserAttribute()
    {
        return $this->attendance_record?->user;
    }

    /**
     * AttendanceRecordを取得
     */
    public function getAttendanceRecordAttribute()
    {
        return $this->attendance_record()->first();
    }

    /**
     * application_dateに申請日時を入力
     */
    public function getApplicationDateAttribute()
    {
        return $this->created_at;
    }

    /**
     * newBreaksを取得
     */
    public function getNewBreaksAttribute()
    {
        return $this->new_break_times()->get();
    }
}
