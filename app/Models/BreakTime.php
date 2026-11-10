<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreakTime extends Model
{
    use HasFactory;

    /**
     * 代入可能な属性
     * @var array<int, datetime>
     */
    protected $fillable = [
        'attendance_record_id',
        'break_in',
        'break_out',
    ];

    /**
     * このbreak_timeが属するattendance_recordを取得
     */
    public function attendance_record(): BelongsTo
    {
        return $this->belongsTo(Attendance_record::class);
    }
}
