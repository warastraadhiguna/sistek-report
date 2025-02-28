<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'technician_id',
        'taxpayer_id',
        'activity_id',
        'request_status_id',
        'arrival_date',
        'return_date',
        'detail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function taxpayer()
    {
        return $this->belongsTo(Taxpayer::class, 'taxpayer_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
    public function requestStatus()
    {
        return $this->belongsTo(RequestStatus::class, 'request_status_id');
    }
}