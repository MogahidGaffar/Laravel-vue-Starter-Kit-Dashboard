<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable =
['module_name','action',
'badge',
'affected_record_id','original_data',
'updated_data','user_id',
'created_at','updated_at',
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'created_at'  => 'date:Y-m-d - H:m',
];



}
