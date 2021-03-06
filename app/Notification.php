<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'read',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
