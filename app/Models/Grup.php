<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Grup extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'grup_name',
        'created_at',
        'updated_at',
    ];

    public function submission()
    {
        return $this->hasOne(Submission::class, 'id_grup', 'id');
    }

    public function member_grup()
    {
        return $this->hasMany(MemberGrup::class, 'id_grup', 'id');
    }
}
