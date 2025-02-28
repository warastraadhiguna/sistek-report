<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device_detail_id',
        'taxpayer_id',
        'serial_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deviceDetail()
    {
        return $this->belongsTo(DeviceDetail::class);
    }

    public function taxpayer()
    {
        return $this->belongsTo(Taxpayer::class);
    }
}