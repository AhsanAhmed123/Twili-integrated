<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Support\Facades\Session;
use Twilio\Laravel\Facades\Twilio;
use App\Models\attendent;
use Illuminate\Support\Facades\Log;

class IVRController extends Controller
{
    public function start(Request $request)
    {
        Session::put('retry_count', 0);
        Log::info('IVR start');
        return $this->askStep("Thank you for calling the visitor registration line. Do you have all your guest’s vehicle information available right now? If yes, press or say 1. If not, and you'd like to send them a link, press or say 2.", '/ivr/step-a1');
    }

    public function stepA1(Request $request)
    {
        $digit = $request->input('Digits');
        Log::info('stepA1 - Digits: ' . $digit);
        if ($digit === '1') return redirect('/ivr/step-a2');
        if ($digit === '2') return redirect('/ivr/step-d1');
        return $this->retryOrFail('/ivr/start');
    }

    public function stepD1() {
        Log::info('stepD1 called');
        return $this->inputStep("Please say or type the phone number of your guest.", '/ivr/step-d2');
    }

    public function stepD2(Request $request)
    {
        $guestPhone = $request->input('SpeechResult') ?? $request->input('Digits');
        Log::info('stepD2 - guestPhone: ' . $guestPhone);
        Session::put('guest_phone', $guestPhone);
        return $this->askStep("Let’s get started. Are we making a Day Pass or an Overnight Pass? For Day press or say 1, for Overnight press or say 2.", '/ivr/step-d3');
    }

    public function stepD3(Request $request)
    {
        $digit = $request->input('Digits');
        Log::info('stepD3 - Digits: ' . $digit);
        $link = $digit === '1'
            ? 'https://goldstarmanor.parkingattendant.com/162bh4s8wn5e7123nfjz4efyw4/permits/temporary/new?policy=xjm4xv3wkn3en6zmdyrnxfqz80'
            : 'https://goldstarmanor.parkingattendant.com/162bh4s8wn5e7123nfjz4efyw4/permits/temporary/new?policy=faw2kj4a015618djqap6vmmcvc';
        Twilio::message(Session::get('guest_phone'), "Please register your vehicle using this link: $link");

        $response = new VoiceResponse();
        $response->say("The registration link has been sent to your guest. Goodbye.");
        $response->hangup();
        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    public function stepA2() {
        Log::info('stepA2 called');
        return $this->askStep("Are we making a Day Pass or an Overnight Pass? Press or say 1 for Day, 2 for Overnight.", '/ivr/step-a3');
    }

    public function stepA3(Request $request)
    {
        $digit = $request->input('Digits');
        $type = $digit === '1' ? 'day' : 'night';
        Log::info('stepA3 - type: ' . $type);
        Session::put('type', $type);

        $response = new VoiceResponse();
        $response->redirect(url('/ivr/step-a4'), ['method' => 'POST']);
        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    public function stepA4() { return $this->saveInput("What is the License Plate Number?", 'license_plate', '/ivr/step-a5'); }
    public function stepA5() { return $this->saveInput("Please say or enter your Apartment Number?", 'apartment', '/ivr/step-a6'); }
    public function stepA6() { return $this->saveInput("Please say or enter your Passcode?", 'passcode', '/ivr/step-a7'); }

    public function stepA7() {
        return $this->askStep("If your visitor will be coming today, press or say 1. If tomorrow, press or say 2.", '/ivr/step-a8');
    }

    public function stepA8(Request $request)
    {
        $digit = $request->input('Digits');
        Log::info('stepA8 - Digits: ' . $digit);
    
        $date = $digit === '1' ? now() : now()->addDay();
        Session::put('start_time', $date);
        Session::put('end_time', $date->copy()->endOfDay());
    
        $response = new \Twilio\TwiML\VoiceResponse();
        $response->redirect(url('/ivr/step-a9'), ['method' => 'POST']);
        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    public function stepA9() { return $this->saveInput("What is the year, color, make, and model of the vehicle?", 'vehicle_info', '/ivr/step-a10'); }
    public function stepA10() { return $this->saveInput("What is the Visitor's first and last name?", 'visitor_name', '/ivr/step-a11'); }
    public function stepA11() { return $this->saveInput("Please say or enter the cell phone number of your visitor.", 'visitor_phone', '/ivr/step-final'); }

    private function saveInput($prompt, $key, $next, $confirmStep = null, $maxRetries = 3)
    {
        $response = new VoiceResponse();
        $retryKey = $key . '_retry_count';
        $speech = request('SpeechResult') ?? request('Digits');
    
        // Field type classification
        $dtmfOnlyKeys = ['license_plate', 'apartment', 'passcode', 'visitor_phone'];
        $speechOnlyKeys = ['vehicle_info'];
    
        // Decide input mode and timing
        if (in_array($key, $dtmfOnlyKeys)) {
            $inputMode = 'dtmf';
            $timeout = 3;
            $speechTimeout = '1';
        } elseif (in_array($key, $speechOnlyKeys)) {
            $inputMode = 'speech';
            $timeout = 10;
            $speechTimeout = 'auto';
        } else {
            $inputMode = 'dtmf speech';
            $timeout = 5;
            $speechTimeout = '1';
        }
    
        // Step 1: Save & Confirm
        if ($speech && !Session::has("confirming_$key")) {
            Session::put($key, $speech);
            Session::put("confirming_$key", true);
    
            $gather = $response->gather([
                'input' => 'dtmf speech',
                'numDigits' => 1,
                'timeout' => 5,
                'speechTimeout' => '1',
                'action' => url()->current(),
                'method' => 'POST'
            ]);
    
            // Speak digits spaced, and sentences plain
            if (in_array($key, $dtmfOnlyKeys)) {
                $spoken = implode(' ', str_split($speech)); // 111 → "1 1 1"
            } else {
                $spoken = $speech;
            }
    
            $gather->say("You entered: $spoken. If this is correct, press 1. If not, press 2.");
            return response($response, 200)->header('Content-Type', 'text/xml');
        }
    
        // Step 2: Handle confirmation
        if (Session::get("confirming_$key")) {
            $confirmation = $speech;
            Session::forget("confirming_$key");
    
            if ($confirmation === '1') {
                $redirect = new VoiceResponse();
                $redirect->redirect(url($next), ['method' => 'POST']);
                return response($redirect, 200)->header('Content-Type', 'text/xml');
            } elseif ($confirmation === '2') {
                Session::forget($key);
                return $this->retryOrFail(url()->current(), $retryKey, $prompt);
            }
        }
    
        // Step 3: Initial ask
        $gather = $response->gather([
            'input' => $inputMode,
            'timeout' => $timeout,
            'speechTimeout' => $speechTimeout,
            'action' => url()->current(),
            'method' => 'POST'
        ]);
        $gather->say($prompt);
    
        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    public function stepFinal(Request $request)
    {
        Log::info('stepFinal - Reached Final Step');
    
        try {
            attendent::create([
                'license_number'   => Session::get('license_plate'),
                'aprt_number'      => Session::get('apartment'),
                'passcode'         => Session::get('passcode'),
                'start_time'       => Session::get('start_time'),
                'end_time'         => Session::get('end_time'),
                'vehicle_details'  => Session::get('vehicle_info'),
                'name'             => Session::get('visitor_name'),
                'email'            => 'noreply@parking.local',
                'phone'            => Session::get('visitor_phone'),
                'notify'           => 'text confirmation only',
                'type'             => Session::get('type', 'day'),
            ]);
        } catch (\Throwable $th) {
            Log::error('DB Save Error in stepFinal', ['error' => $th->getMessage()]);
            $response = new \Twilio\TwiML\VoiceResponse();
            $response->say("There was an error saving the visitor pass. Please try again later. Goodbye.");
            $response->hangup();
            return response($response, 200)->header('Content-Type', 'text/xml');
        }
    
        // Send SMS confirmation
        try {
            Twilio::message(Session::get('visitor_phone'), "Your parking pass has been registered successfully.");
        } catch (\Throwable $th) {
            Log::error('SMS Error in stepFinal', ['error' => $th->getMessage()]);
        }
    
        // Clear session to prevent large payloads
        Session::forget([
            'license_plate', 'apartment', 'passcode', 'start_time',
            'end_time', 'vehicle_info', 'visitor_name', 'visitor_phone',
            'type', 'guest_phone'
        ]);
    
        // Build TwiML Response
        $response = new \Twilio\TwiML\VoiceResponse();
    
        $gather = $response->gather([
            'input' => 'dtmf speech',
            'numDigits' => 1,
            'timeout' => 3,
            'speechTimeout' => '1',
            'action' => url('/ivr/step-final-decision'),
            'method' => 'POST'
        ]);
        $gather->say("Visitor pass submitted successfully. If you need to make another visitor pass, press or say 1. If you are finished, press or say 2.");
    
        return response($response, 200)->header('Content-Type', 'text/xml');
    }


    public function stepFinalDecision(Request $request)
    {
        $digit = $request->input('Digits');

        $response = new VoiceResponse();
    
        if ($digit === '1') {
            $response->redirect(url('/ivr/step-a2'), ['method' => 'POST']);
        } elseif ($digit === '2') {
            $response->say("Thank you for using the visitor registration line. Goodbye.");
            $response->hangup();
        } else {
            $gather = $response->gather([
                'input' => 'dtmf speech',
                'numDigits' => 1,
                'timeout' => 3,
                'speechTimeout' => '1',
                'action' => url('/ivr/step-final-decision'),
                'method' => 'POST'
            ]);
            $gather->say("I didn't catch that. To make another pass, press 1. To end the call, press 2.");
        }
    
        return response($response, 200)->header('Content-Type', 'text/xml');
    }
    


    private function askStep($question, $action)
    {
        $response = new VoiceResponse();
        $gather = $response->gather([
            'input' => 'dtmf speech',
            'numDigits' => 1,
            'timeout' => 15,
            'speechTimeout' => '1',
            'action' => url($action),
            'method' => 'POST'
        ]);
        $gather->say($question);
        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    private function inputStep($prompt, $action)
    {
        $response = new VoiceResponse();
        $gather = $response->gather([
            'input' => 'dtmf speech',
            'timeout' => 15,
            'action' => url($action),
            'method' => 'POST'
        ]);
        $gather->say($prompt);
        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    // private function retryOrFail($redirectUrl)
    // {
    //     $count = Session::get('retry_count', 0) + 1;
    //     Session::put('retry_count', $count);

    //     $response = new VoiceResponse();
    //     if ($count >= 3) {
    //         $response->say("I'm sorry, I wasn't able to get your response. Goodbye.");
    //         $response->hangup();
    //     } else {
    //         $gather = $response->gather([
    //             'input' => 'dtmf speech',
    //             'numDigits' => 1,
    //             'timeout' => 15,
    //             'action' => url($redirectUrl),
    //             'method' => 'POST'
    //         ]);
    //         $gather->say("I didn't catch that. Let's try again.");
    //     }
    //     return response($response, 200)->header('Content-Type', 'text/xml');
    // }

    private function retryOrFail($redirectUrl, $retryKey = 'retry_count', $customMessage = null)
    {
        $count = Session::get($retryKey, 0) + 1;
        Session::put($retryKey, $count);

        $response = new VoiceResponse();

        if ($count >= 3) {
            $response->say("I cannot register your guest with the information provided. Goodbye.");
            $response->hangup();
        } else {
            $gather = $response->gather([
                'input' => 'dtmf speech',
                'timeout' => 10,
                'speechTimeout' => '1',
                'action' => $redirectUrl,
                'method' => 'POST'
            ]);
            $gather->say($customMessage ?? "I didn’t catch that. Let's try again.");
        }

        return response($response, 200)->header('Content-Type', 'text/xml');
    }

}
