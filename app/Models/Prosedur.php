<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prosedur extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'file_prosedur',
        'created_at',
        'updated_at',
    ];
}
