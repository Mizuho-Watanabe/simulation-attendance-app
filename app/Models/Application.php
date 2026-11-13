<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'date',
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
        return $this->belongsTo(Attendance_record::class);
    }

    /**
     * approval_statusを取得
     */
    const STATUS_PEND_APPROVAL = 0;
    const STATUS_APPROVED = 1;

    public function getApprovalStatusAttribute(): string
    {
        return $this->approval_status ? '承認済み' : '承認待ち';
    }
}
