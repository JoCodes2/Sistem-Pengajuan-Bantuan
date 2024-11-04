<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGrup extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_grup',
        'name',
        'address',
        'ttl',
        'nik',
        'status'
    ];

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup');
    }
}
