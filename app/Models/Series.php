<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Series extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'study_id',
        'series_instance_uid',
        'modality',
        'description',
    ];

    public function study()
    {
        return $this->belongsTo(Study::class);
    }
}
