<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    /**
     * リクエストの認可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルールの設定
     */
    public function rules(): array
    {
        return [
            'new_clock_in' => ['required', 'date_format:H:i:s'],
            'new_clock_out' => ['required', 'date_format:H:i:s', 'after:new_clock_in'],
            'new_break_in' => ['array'],
            'new_break_in.*' => ['date_format:H:i:s', 'after:new_clock_in', 'before:new_clock_out', ],
            'new_break_out' => ['array'],
            'new_break_out.*' => ['date_format:H:i:s', 'before:new_clock_out'],
            'comment' => ['required', 'string', 'max:255'],
        ];
    }

     public function messages(): array
    {
        return [
            'new_clock_in.required' => '出勤時間を入力してください',
            'new_clock_out.required' => '退勤時間を入力してください',
            'new_clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です',
            'new_break_in.*.after' => '休憩時間が不適切な値です',
            'new_break_in.*.before' => '休憩時間が不適切な値です',
            'new_break_out.*.before' => '休憩時間もしくは退勤時間が不適切な値です',
            'comment.required' => '備考を記入してください',
        ];
    }
}
