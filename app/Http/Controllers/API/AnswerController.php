<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function guess(Request $request){
        // Check if answer is correct
        $correct = session()->get('correct');

        if ($correct['id'] === $request->get('answerId')) {
            return response()->json(['correctAnswer' => true, 'message' => 'Correct answer!']);
        }

        return response()->json(['correctAnswer' => false, 'message' => 'Wrong answer!']);
    }

}
