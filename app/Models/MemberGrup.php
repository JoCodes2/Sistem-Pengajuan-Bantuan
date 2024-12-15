<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGrup extends Model
{
    use HasFactory, HasUuids;

    protected $table = "member_grups";

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

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup', 'id');
    }
}
