<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device_type_id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }
}