<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Study extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id',
        'orthanc_id',
        'study_instance_uid',
        'study_date',
        'description',
        'accession_number',
        'modality',
        'priority',
        'status',
        'assigned_to',
        'reported_at',
    ];

    protected $casts = [
        'study_date'  => 'date',
        'reported_at' => 'datetime',
    ];

   

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function series()
    {
        return $this->hasMany(Series::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function assignedRadiologist()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

   

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    

    public function isFinalized(): bool
    {
        return $this->status === 'finalized';
    }

    public function isUrgent(): bool
    {
        return $this->priority === 'urgent';
    }
}
