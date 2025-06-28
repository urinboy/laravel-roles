<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'number',
        'date',
        'inventory_numbers',
        'pdf_path',
        'description',
        'user_id',
    ];

    protected $casts = [
        'inventory_numbers' => 'array',
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
