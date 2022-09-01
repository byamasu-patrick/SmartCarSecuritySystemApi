<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Models\AlertInfo;
use App\Models\MotionSensor;

class CarInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_type',
        'car_serial_number',
        'car_profile',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function alert_infos()
    {
        return $this->hasMany(AlertInfo::class);
    }
    public function motion_sensors()
    {
        return $this->hasMany(MotionSensor::class);
    }
   
    
}
