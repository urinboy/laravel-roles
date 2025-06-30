<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // HasFactory traitini import qilish
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // BelongsToMany munosabati uchun type hint

class ResponsiblePerson extends Model
{
    use HasFactory; // Model Factorydan foydalanish uchun trait

    /**
     * The attributes that are mass assignable.
     * Mass assignable xususiyatlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'passport_pdf_path',
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
     * The rooms that are assigned to the responsible person.
     * Ushbu mas'ul shaxsga biriktirilgan xonalarni (rooms) olish.
     * Bu 'ko'pga-ko'p' (many-to-many) munosabatdir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rooms(): BelongsToMany // BelongsToMany munosabati uchun type hint
    {
        // 'room_responsible_person' - bu pivot jadval nomi.
        // Agar nomlash standartiga amal qilgan bo'lsangiz (ya'ni, 'room_id' va 'responsible_person_id' ustunlari mavjud bo'lsa),
        // uchinchi argument (ustun nomlari) shart emas. Lekin aniqlik uchun yozish yaxshi.
        return $this->belongsToMany(Room::class, 'room_responsible_person', 'responsible_person_id', 'room_id');
    }
}
