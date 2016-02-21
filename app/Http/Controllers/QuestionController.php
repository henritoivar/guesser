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
        // Get our options
        $options = $this->getOptions();

        // Choose a correct answer
        $correct = $options->random();

        // Remember the correct answer
        session()->put('correct', $correct);

        return view('question')->with(compact('options', 'correct'));
    }

    public function getOptions(){

        // Get location
        $location = session()->get('location');

        // Get images
        $listingUrl = 'https://api.flickr.com/services/rest';
        $params = array(
            'method' => 'flickr.photos.search',
            'api_key' => '9b90f979966452f5c7ce6ab915022473',
            'lat' => $location['latitude'],
            'lon' => $location['longitude'],
            'has_geo' => 1,
            'format' => 'json',
            'nojsoncallback' => 1,
            'sort' => 'interestingness-desc',
            'accuracy' => '16',
            'radius' => '15',
            'extras' => 'geo,url_m,url_z,url_c,url_l',
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

        $options = $listingCollection->random(4);

        // Assign a letter to each option
        $letters = collect(range('A', 'Z'));
        $options->transform(function ($item) use ($letters) {
            $item['letter'] = $letters->shift();
            return $item;
        });

        return $options;
    }

    public function test(){
        return $this->getPhotoInfo(['id' => '6009545279', 'secret' => '146a08bdc2']);
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
