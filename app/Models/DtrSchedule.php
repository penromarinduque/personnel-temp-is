<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtrSchedule extends Model
{
    //
    protected $table = 'dtr_schedules';
    protected $guarded = [];

    protected $casts = [
        "start_date" => "datetime",
        "end_date" => "datetime",
    ];

    public function personnel()
    {
        return $this->belongsTo(UserInfo::class, 'userinfo_id');
    }

    public function dtrOption()
    {
        return $this->belongsTo(DtrOption::class, 'dtr_option_id');
    }
}
