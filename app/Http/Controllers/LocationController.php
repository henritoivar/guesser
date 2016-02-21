<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function showLocationChoice()
    {
        return view('location');

    }

    public function setLocation(Request $request)
    {
        // Set location
        session()->set('location', array(
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude')
        ));

        // Set lives and score
        $lives = session()->get('lives');
        if (!$lives) {
            session()->put('lives', config('lives.default'));
            session()->put('score', 0);
        }

        return redirect()->action('QuestionController@showQuestion');
    }
}
