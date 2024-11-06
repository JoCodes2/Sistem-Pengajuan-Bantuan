<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGrup extends Model
{
    use HasFactory;

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

    public function grup()
    {
        return $this->hasMany(Grup::class, 'id_grup', 'id');
    }
}
