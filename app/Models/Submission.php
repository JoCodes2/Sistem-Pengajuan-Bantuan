<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['id_grup', 'date', 'description', 'file_proposal'];

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'id_grup');
    }
}
