<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Notifiaction extends Model 
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];


    
    public function getFormattedCreatedAtAttribute(): string
{
    return $this->created_at->format('d M Y');
}

}
