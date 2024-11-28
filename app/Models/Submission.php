<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'id_grup',
        'date',
        'status_submissions',
        'description',
        'file_proposal',
        'created_at',
        'updated_at'
    ];

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
