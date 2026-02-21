<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Patient extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dicom_patient_id',
        'name',
        'birth_date',
        'sex',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function studies()
    {
        return $this->hasMany(Study::class);
    }
}
