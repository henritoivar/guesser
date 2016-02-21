<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use Auth;
use Session;

class GameController extends Controller
{
    public function home()
    {
        // Get our options
        $options = $this->getOptions();

        // Choose a correct answer
        $correct = $options->random();

        // Remember the correct answer
        Session::put('correct', $correct);

        return view('home')->with(compact('options', 'correct'));
    }

    private function getOptions(){

        // Get images
        $listingUrl = 'https://api.flickr.com/services/rest';
        $params = array(
            'method' => 'flickr.photos.search',
            'api_key' => '9b90f979966452f5c7ce6ab915022473',
            'lat' => '37.7925891',  /*'59.4427685',*/
            'lon' => '-122.4071576', /*'24.731148',*/
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

        $options = $listingCollection->random(4);

        // Assign a letter to each option
        $letters = collect(range('A', 'Z'));
        $options->transform(function ($item) use ($letters) {
            $item['letter'] = $letters->shift();
            return $item;
        });

        return $options;
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
