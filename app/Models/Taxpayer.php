<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxpayer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'number',
        'name',
        'business_name',
        'address',
        'email',
        'phone',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}