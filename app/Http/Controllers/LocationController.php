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
        session()->set('location', array(
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude')
        ));

        return redirect()->action('QuestionController@showQuestion');
    }
}
