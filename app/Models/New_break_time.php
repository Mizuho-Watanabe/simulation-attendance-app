<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class New_break_time extends Model
{
    use HasFactory;

    /**
     * 代入可能な属性
     * @var array<int, datetime>
     */
    protected $fillable = [
        'application_id',
        'new_break_in',
        'new_break_out',
    ];

    /**
     * このbreak_timeが属するattendance_recordを取得
     */
    public function attendance_record(): BelongsTo
    {
        return $this->belongsTo(Attendance_record::class);
    }
}
