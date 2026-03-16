<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAbonement extends Model
{
    protected $fillable = [
        'user_id',
        'abonement_id',
        'visits_left',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function abonement() {
        return $this->belongsTo(Abonement::class);
    }
}
