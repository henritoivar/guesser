<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;

class AnswerController extends Controller
{
    public function guess(Request $request){
        // Check if answer is correct
        $correct = session()->get('correct');

        if ($correct['id'] === $request->get('answerId')) {
            $answerCorrect = true;
            $message = 'Correct answer!';
        }else{
            $answerCorrect = false;
            $message = 'Wrong answer!';
        }

        // Get photo full info
        $details = $this->getPhotoInfo($correct);
        $details = $details['photo'];

        // Get icon url
        if (isset($details['owner']['iconfarm'])) {
            $details['owner']['iconUrl'] = 'http://farm' . $details['owner']['iconfarm'] . '.staticflickr.com/' . $details['owner']['iconserver'] . '/buddyicons/' . $details['owner']['nsid'] . '.jpg';
        }

        // Get how many days ago it was taken
        if (isset($details['dates']['taken'])) {
            $details['dates']['takenDate'] = Carbon::createFromFormat('Y-m-d H:i:s', $details['dates']['taken']);
        }

        // Render details html
        $detailsHtml = view()->make('answer-details', compact('details', 'answerCorrect'))->render();

        return response()->json(['answerCorrect' => $answerCorrect, 'message' => $message, 'detailsHtml' => $detailsHtml]);
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
