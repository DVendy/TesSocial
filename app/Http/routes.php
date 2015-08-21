<?php

use SammyK\LaravelFacebookSdk\FacebookFacade as Facebook;
use App\Social;
use App\User;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('account', 'WelcomeController@account');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	]);

Route::get('/facebook/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	$login_url = $fb->getLoginUrl(['email', 'publish_actions'], '/facebook/callback');
	return redirect($login_url."&display=popup");
});

Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	$accessToken = null;
	try {
		$accessToken = Facebook::getAccessTokenFromRedirect();
	}catch(\Facebook\Exceptions\FacebookSDKException $e){
		return ('Dapet link darimana? :v');
	}

	if (! $accessToken) {
		return ('Login / permission jangan di cancel :v');
	}

	if (! $accessToken->isLongLived()) {
	        // OAuth 2.0 client handler
		$oauth_client = $fb->getOAuth2Client();

	        // Extend the access token.
		try {
			$accessToken = $oauth_client->getLongLivedAccessToken($accessToken);
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			return ('c');
		}
	}

	Session::put('facebook_access_token', (string) $accessToken);

	Facebook::setDefaultAccessToken($accessToken);

		// If token expired
	if(empty($accessToken))
		return ('d!');
	try {
		$response = Facebook::get('/me?fields=id,name,email');
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		dd($e->getMessage());
	}

	$timeline= $response->getGraphObject();
    // var_dump($timeline);
    // die();

	$social = Social::where('social_id', '=', $timeline['id'])->first();
	if ($social == null){
		$user = new User();
		$user->email = $timeline['email'];
		$user->name = $timeline['name'];
		$user->password = "-";
		$user->save();

		$social = new Social();
		$social->type = "facebook";
		$social->social_id = $timeline['id'];
		$social->token = $accessToken;
		$social->user_id = $user->id;
		$social->save();

		Auth::login($user);
		return "<script>
            window.close();
            window.opener.location.reload();
            </script>";
	}
	else{
		Auth::login($social->user);
		$social->token = $accessToken;
		$social->save();
		return "<script>
            window.close();
            window.opener.location.reload();
            </script>";
	}

	//return redirect(action('PageController@term'));
});

Route::get('/facebook/post', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	if (!Auth::check())
		return redirect('/');

	$user = Auth::user();
	$accessToken = null;
	try {
		foreach ($user->social as $key) {
			if ($key->type = "facebook")
				$accessToken = $key->token;
		}
	}catch(\Facebook\Exceptions\FacebookSDKException $e){
		return redirect('/facebook/login');
	}

	if (! $accessToken) {
		return redirect('account');
	}

	Facebook::setDefaultAccessToken($accessToken);

		// If token expired
	if(empty($accessToken))
		return redirect('account');

	$linkData = [
	'link' => 'https://scotch.io/tutorials/a-guide-to-using-eloquent-orm-in-laravel',
	'message' => 'User provided message',
	];

	try {
  // Returns a `Facebook\FacebookResponse` object
		$response = Facebook::post('/me/feed', $linkData, $accessToken);
	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$graphNode = $response->getGraphNode();

	echo 'Posted with id: ' . $graphNode['id'];
	die();
});

Route::get('/facebook/photo', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	if (!Auth::check())
		return redirect('/');

	$user = Auth::user();
	$accessToken = null;
	try {
		foreach ($user->social as $key) {
			if ($key->type = "facebook")
				$accessToken = $key->token;
		}
	}catch(Facebook\Exceptions\FacebookSDKException $e){
		return redirect('/facebook/login');
	}

	if (! $accessToken) {
		return redirect('account');
	}

	Facebook::setDefaultAccessToken($accessToken);

		// If token expired
	if(empty($accessToken))
		return redirect('account');

	// var_dump(storage_path('images/a.jpeg'));
	// die();

	$data = [
	'message' => 'My awesome photo upload example.',
	'source' => $fb->fileToUpload('images/a.jpg'),
	];

	try {
  // Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/me/photos', $data, $accessToken);
	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$graphNode = $response->getGraphNode();

	echo 'Photo ID: ' . $graphNode['id'];
	$photoLink = 'https://www.facebook.com/photo.php?fbid='.$graphNode['id'].'&makeprofile=1';
	return Redirect::to($photoLink);
	//die();
});

Route::get('/facebook/cover', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
	if (!Auth::check())
		return redirect('/');

	$user = Auth::user();
	$accessToken = null;
	try {
		foreach ($user->social as $key) {
			if ($key->type = "facebook")
				$accessToken = $key->token;
		}
	}catch(Facebook\Exceptions\FacebookSDKException $e){
		return redirect('/facebook/login');
	}

	if (! $accessToken) {
		return redirect('account');
	}

	Facebook::setDefaultAccessToken($accessToken);

		// If token expired
	if(empty($accessToken))
		return redirect('account');

	// var_dump(storage_path('images/a.jpeg'));
	// die();

	$data = [
	'message' => 'My awesome photo upload example.',
	'source' => $fb->fileToUpload('images/a.jpg'),
	];

	try {
  // Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/me/photos', $data, $accessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$graphNode = $response->getGraphNode();

	echo 'Photo ID: ' . $graphNode['id'];
	$photoLink = 'https://www.facebook.com/profile.php?preview_cover='.$graphNode['id'];
	return Redirect::to($photoLink);
	//die();
});

Route::get('twitter/login', ['as' => 'twitter.login', function(){
    // your SIGN IN WITH TWITTER  button should point to this route
    $sign_in_twitter = true;
    $force_login = false;

    // Make sure we make this request w/o tokens, overwrite the default values in case of login.
    Twitter::reconfig(['token' => '', 'secret' => '']);
    $token = Twitter::getRequestToken(route('twitter.callback'));

    if (isset($token['oauth_token_secret']))
    {
        $url = Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);

        Session::put('oauth_state', 'start');
        Session::put('oauth_request_token', $token['oauth_token']);
        Session::put('oauth_request_token_secret', $token['oauth_token_secret']);

        return Redirect::to($url);
    }

    return Redirect::route('twitter.error');
}]);

Route::get('twitter/callback', ['as' => 'twitter.callback', function() {
    // You should set this route on your Twitter Application settings as the callback
    // https://apps.twitter.com/app/YOUR-APP-ID/settings
    if (Session::has('oauth_request_token'))
    {
        $request_token = [
            'token'  => Session::get('oauth_request_token'),
            'secret' => Session::get('oauth_request_token_secret'),
        ];

        Twitter::reconfig($request_token);

        $oauth_verifier = false;

        if (Input::has('oauth_verifier'))
        {
            $oauth_verifier = Input::get('oauth_verifier');
        }

        // getAccessToken() will reset the token for you
        $token = Twitter::getAccessToken($oauth_verifier);

        if (!isset($token['oauth_token_secret']))
        {
            return Redirect::route('twitter.login')->with('flash_error', 'We could not log you in on Twitter.');
        }

        $credentials = Twitter::getCredentials();

        if (is_object($credentials) && !isset($credentials->error))
        {
            // $credentials contains the Twitter user object with all the info about the user.
            // Add here your own user logic, store profiles, create new users on your tables...you name it!
            // Typically you'll want to store at least, user id, name and access tokens
            // if you want to be able to call the API on behalf of your users.

            // This is also the moment to log in your users if you're using Laravel's Auth class
            // Auth::login($user) should do the trick.

            Session::put('access_token', $token);
            Session::save();

            echo "credentials : ";
            var_dump($credentials);
            die();

            return Redirect::to('/')->with('flash_notice', 'Congrats! You\'ve successfully signed in!');
        }

        return Redirect::route('twitter.error')->with('flash_error', 'Crab! Something went wrong while signing you up!');
    }
}]);

Route::get('twitter/tweet', function()
{
    return Twitter::request('POST', 'https://api.twitter.com/1.1/statuses/update.json',
    array( 'status' => "One Piece is still the best #OnePiece"),
    true, // use auth
    true // multipart
    );
});

Route::get('twitter/pp', function()
{
	$contents = Storage::get('a.jpg');
    $code = Twitter::request('POST', 'https://api.twitter.com/1.1/account/update_profile_image.json',
    array( 'image' => $contents),
    true, // use auth
    true // multipart
    );
    var_dump($code);
    exit();
});

Route::get('twitter/banner', function()
{
	$contents = Storage::get('d.jpg');
    $code = Twitter::request('POST', 'https://api.twitter.com/1.1/account/update_profile_banner.json',
    array( 'banner' => $contents),
    true, // use auth
    true // multipart
    );
    var_dump($code);
    exit();
});