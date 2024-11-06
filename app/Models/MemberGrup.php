<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGrup extends Model
{
    use HasFactory, HasUuids;
    // Nama tabel
    protected $table = 'member_grup';

    // Mass assignable attributes
    protected $fillable = [
        'id',
        'id_grup',
        'name',
        'address',
        'tempat',
        'tanggal_lahir',
        'nik',
        'status',
        'created_at',
        'updated_at',
    ];

    // Relasi dengan model Ormas
    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup');
    }
}
