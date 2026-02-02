<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
    'user_id',
    'type',
    'latitude',
    'longitude',
    'description',
    'status',
    'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function confirmations()
    {
        return $this->hasMany(ReportConfirmation::class);
    }

    public function confirmationsCount()
    {
        return $this->confirmations()->where('is_helpful', true)->count();
    }

    
}
