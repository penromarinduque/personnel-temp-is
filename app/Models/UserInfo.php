<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //
    protected $table = "userinfo";

    protected $primaryKey = "userID";

    public $timestamps = false;

    protected $fillable = [
        'userID',
        'badgeNumber',
        'dahua_id',
        'division',
        'SSN',
        'name',
        'first_name',
        'middle_initial',
        'last_name',
        'ext_name',
        'gender',
        'position',
        'contact',
        'birthday',
        'hiredday',
        'address',
        'tin',
        'salary_type',
        'monthly_rate',
        'daily_rate',
        'hourly_rate',
        'w_premium',
        'pap',
        'status',
        'is_active',
        'is_fwa',
        '_start_date',
    ];
}
