<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewBreakTime extends Model
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
     * このnew_break_timeが属するapplicationを取得
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
