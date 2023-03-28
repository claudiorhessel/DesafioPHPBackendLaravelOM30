<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
