<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // HasFactory traitini import qilish
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // BelongsTo munosabati uchun type hint
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // BelongsToMany munosabati uchun type hint

class Room extends Model
{
    use HasFactory; // Model Factorydan foydalanish uchun trait

    /**
     * The attributes that are mass assignable.
     * Mass assignable xususiyatlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'floor_id',
        'number',
        'name',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     * Tip konvertatsiyasi kerak bo'lgan xususiyatlar.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the floor that owns the room.
     * Xona tegishli bo'lgan qavatni (floor) olish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function floor(): BelongsTo // BelongsTo munosabati uchun type hint
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * The responsible people that belong to the room.
     * Xonaga biriktirilgan mas'ul shaxslarni (responsible people) olish.
     * Bu 'ko'pga-ko'p' (many-to-many) munosabatdir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responsiblePeople(): BelongsToMany // BelongsToMany munosabati uchun type hint
    {
        // 'room_responsible_person' - bu pivot jadval nomi.
        // Agar nomlash standartiga amal qilgan bo'lsangiz (ya'ni, 'room_id' va 'responsible_person_id' ustunlari mavjud bo'lsa),
        // uchinchi argument (ustun nomlari) shart emas. Lekin aniqlik uchun yozish yaxshi.
        return $this->belongsToMany(ResponsiblePerson::class, 'room_responsible_person', 'room_id', 'responsible_person_id');
    }
}
