<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsiblePerson extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'passport_pdf_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'responsible_person_id');
    }
}
