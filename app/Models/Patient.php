<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'mother_name',
        'birtdate',
        'cpf',
        'cns',
    ];

    public function rules()
    {
        return [
            'name' => 'required',
            'mother_name' => 'required',
            'birtdate' => 'required',
            'cpf' => 'required|unique',
            'cns' => 'required|unique'
        ];
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
