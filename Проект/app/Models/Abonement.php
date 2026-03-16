<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonement extends Model
{
    protected $fillable = [
        'name',
        'description',
        'visits',
        'price',
    ];

    public function userAbonements() {
        return $this->hasMany(UserAbonement::class);
    }
}
