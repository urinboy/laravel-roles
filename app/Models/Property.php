<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name', 'equipment_type_id'];

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
