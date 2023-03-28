<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'file_type_id',
        'patient_id',
        'original_name',
        'file_path',
        'file_size',
        'hash'
    ];

    public static function rules()
    {
        return [
            'file_type_id' => 'required',
            'patient_id' => 'required',
            'original_name' => 'required',
            'file_path' => 'required',
            'file_size' => 'required',
            'hash' => 'required'
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function file_type()
    {
        return $this->hasOne(FileType::class);
    }
}
