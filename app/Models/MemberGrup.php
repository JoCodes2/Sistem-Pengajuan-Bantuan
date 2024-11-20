<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGrup extends Model
{
    use HasFactory, HasUuids;
<<<<<<< HEAD
    // Nama tabel
    protected $table = 'member_grup';
=======
>>>>>>> 5df66dcd537e39058f3d6e6cd1041e51308289c6

    // Mass assignable attributes
    protected $fillable = [
        'id',
        'id_grup',
        'name',
        'address',
        'place_birth',
        'date_birth',
        'nik',
        'status',
        'created_at',
        'updated_at',
    ];

    // Relasi dengan model Ormas
    public function grup()
    {
<<<<<<< HEAD
        return $this->belongsTo(Grup::class, 'id_grup');
=======
        return $this->belongsTo(Grup::class, 'id_grup', 'id');
>>>>>>> 5df66dcd537e39058f3d6e6cd1041e51308289c6
    }
}
