<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use Auth;

class AuthController extends Controller
{
    public function showLogin(){
        // Get auth url
        $params = array(
            'client_id' => config('instagram.client_id'),
            'redirect_uri' => action('AuthController@instagramAuth'),
            'response_type' => 'code'
        );
        $authUrl = 'https://api.instagram.com/oauth/authorize/?' . http_build_query($params);

        // Show view
        return view( 'auth' )->with( compact( 'authUrl' ) );
    }

    public function instagramAuth(Request $request)
    {
        $accessTokenUrl = 'https://api.instagram.com/oauth/access_token';

        $params = [
            'code' => $request->input('code'),
            'client_id' => config('instagram.client_id'),
            'client_secret' => config('instagram.client_secret'),
            'redirect_uri' => action('AuthController@instagramAuth'),
            'grant_type' => 'authorization_code',
        ];

        $client = new GuzzleHttp\Client();

        $accessTokenResponse = $client->post($accessTokenUrl, ['form_params' => $params]);
        $response = json_decode($accessTokenResponse->getBody(), true);

        $accessToken = $response['access_token'];
        $profile = $response['user'];

        // Check if user already exists
        $user = User::where('instagram_user_id', '=', $profile['id'])->first();

        // User doesn't exist
        if (!$user) {

            $user = new User;
            $user->instagram_user_id = $profile['id'];
            $user->instagram_username = $profile['username'];
        }

        // Store the access token
        $user->instagram_access_token = $accessToken;
        $user->save();

        // Log the user in
        Auth::login($user);

        return redirect()->action( 'GameController@home' );
    }
}
