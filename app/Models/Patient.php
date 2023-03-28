<?php

namespace App\Models;

use App\Rules\ValidCPFRule;
use App\Rules\ValidCNSRule;
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

    public static function rules()
    {
        return [
            'name' => 'required',
            'mother_name' => 'required',
            'birtdate' => 'required|before:now|date_format:Y-m-d',
            'cpf' => ['required', 'unique:patients,cpf,NULL,id,deleted_at,NULL', new ValidCPFRule()],
            'cns' => ['required', 'unique:patients,cns,NULL,id,deleted_at,NULL', new ValidCNSRule()]
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
