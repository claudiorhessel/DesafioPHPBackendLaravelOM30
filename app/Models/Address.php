<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }

    public function address_type()
    {
        return $this->hasOne(AddressType::class);
    }
}
