<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CarInfo;

class AlertInfo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'car_info_id',
        'description',
        'alarm_state',
        'picture'
    ];

    public function car_info()
    {
        return $this->belongsTo(CarInfo::class);
    }
    
    
}
