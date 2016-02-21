<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;

class AnswerController extends Controller
{
    public function guess(Request $request){
        // Check if answer is correct
        $correct = session()->get('correct');

        // Get photo full info
        $details = $this->getPhotoInfo($correct);

        // Render details html
        $detailsHtml = view()->make('answer-details', ['details' => $details['photo']])->render();

        if ($correct['id'] === $request->get('answerId')) {
            return response()->json(['correctAnswer' => true, 'message' => 'Correct answer!', 'detailsHtml' => $detailsHtml]);
        }

        return response()->json(['correctAnswer' => false, 'message' => 'Wrong answer!', 'detailsHtml' => $detailsHtml]);
    }

    private function getPhotoInfo($photo)
    {

        $imageInfoUrl = 'https://api.flickr.com/services/rest';
        $params = array(
            'method' => 'flickr.photos.getInfo',
            'api_key' => '9b90f979966452f5c7ce6ab915022473',
            'photo_id' => $photo['id'],
            'secret' => $photo['secret'],
            'format' => 'json',
            'nojsoncallback' => 1
        );

        $client = new GuzzleHttp\Client();

        $infoResponseRaw = $client->get($imageInfoUrl, ['query' => $params]);
        $infoResponse = json_decode($infoResponseRaw->getBody(), true);

        return $infoResponse;
    }

}
