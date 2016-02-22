<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use Auth;

class QuestionController extends Controller
{
    public function showQuestion()
    {
        // Check if session is set
        if (!session()->get('lives')) {
            return redirect()->action('LocationController@setLocation');
        }

        // Get our options
        $options = $this->getOptions(session()->get('location'));

        //  Not enough options
        if (!$options) {
            return redirect()->action('LocationController@showLocationChoice')
                ->withErrors(['Nobody hangs out here! Choose another place']);
        }

        // Choose a correct answer
        $correct = $options->random();

        // Assign a letter to each option
        // Also remove unnesseccery clutter (possible cheats)
        $letters = collect(range('A', 'Z'));
        $options->transform(function ($item) use ($letters) {
            $itemClean = array(
                'letter' => $letters->shift(),
                'id' => $item['id'],
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude']
            );

            return $itemClean;
        });

        // Remember the correct answer
        session()->put('correct', $correct);

        return view('question')->with(compact('options', 'correct'));
    }

    private function getOptions($location){

        // Get images
        $listingUrl = 'https://api.flickr.com/services/rest';
        $params = array(
            'method' => 'flickr.photos.search',
            'api_key' => config('flickr.key'),
            'lat' => $location['latitude'],
            'lon' => $location['longitude'],
            'has_geo' => 1,
            'format' => 'json',
            'nojsoncallback' => 1,
            'sort' => 'interestingness-desc',
            'accuracy' => '16',
            'radius' => '20',
            'extras' => 'geo,url_c',
            //'tags' => 'cake',
            // 'tag_mode' => 'all'
        );

        $client = new GuzzleHttp\Client();

        $listingResponseRaw = $client->get($listingUrl, ['query' => $params]);
        $listingResponse = json_decode($listingResponseRaw->getBody(), true);

        // Get 4 images from the result
        $listingCollection = collect($listingResponse['photos']['photo']);

        // Filter out images without big image
        $listingCollection = $listingCollection->filter(function ($item) {
            return isset($item['url_c']);
        });

        if ($listingCollection->count() < 4) {
            return false;
        }

        $options = $listingCollection->random(4);

        return $options;
    }

}
