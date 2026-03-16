<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'trainer_id',
        'name',
        'date',
        'capacity',
        'status',
    ];

    public function trainer() {
        return $this->belongsTo(User::class, 'trainer_id');
    }
    public function activities() {
        return $this->hasMany(UserActivity::class);
    }
}
