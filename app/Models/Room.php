<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function responsiblePerson()
    {
        return $this->belongsTo(ResponsiblePerson::class, 'responsible_people');
    }
}
