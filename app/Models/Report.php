<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Report extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'study_id',
        'user_id',
        'findings',
        'impression',
        'status',
    ];

    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
