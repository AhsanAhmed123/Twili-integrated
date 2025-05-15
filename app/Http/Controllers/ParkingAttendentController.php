<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendent;

class ParkingAttendentController extends Controller
{
    public function parkingAttendentDay()
    {
        return view('parking.index');
    }

    public function parkingAttendentNight()
    {
        return view('parking.nightattendent');
    }

    public function dayparkingstore()
    {
        
        try {
            $validation = request()->validate([
                'license_number'      => 'required',
                'aprt_number'         => 'required',
                'passcode'            => 'required',
                'start_time'          => 'required',
                'end_time'            => 'required',
                'vehicle_details'     => 'required',
                'name'                => 'required',
                'email'               => 'required',
                'phone'               => 'required',
                'notify'              => 'required',
            ]);

            $validation['type'] = request()->input('type') === 'day' ? 'day' : 'night';
           
            attendent::create($validation);
        return redirect()->back()->with('success', 'Record added successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error in adding record'); 
        }
    
    }
}
