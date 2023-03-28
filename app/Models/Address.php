<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'address_type_id',
        'patient_id',
        'cep',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public static function rules()
    {
        return [
            'address_type_id' => 'required',
            'patient_id' => 'required',
            'cep' => 'required',
            'address' => 'required',
            'number' => 'required',
            'complement' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function address_type()
    {
        return $this->hasOne(AddressType::class);
    }
}
