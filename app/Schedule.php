<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable=[
        'sched_id',
        'title',
        'start_date',
        'staff',
        'notify_email',
        'email_to_notif',
        'notify_sms',
        'sms_to_notif'
    ];
}
