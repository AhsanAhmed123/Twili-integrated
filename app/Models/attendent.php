<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendent extends Model
{
    
    use HasFactory;

    protected $table = 'attendents';

    public $timestamps = false;

    protected $fillable = [
        'license_number',
        'aprt_number',
        'type',
        'passcode',
        'start_time',
        'end_time',
        'vehicle_details',
        'name',
        'email',
        'phone',
        'notify',
    ];
    


}
