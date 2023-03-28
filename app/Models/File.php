<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }

    public function file_type()
    {
        return $this->hasOne(FileType::class);
    }
}
