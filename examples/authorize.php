<?php

/*
 * This example demonstrates the complete flow to get a user id with
 * its access token to be able to act on his behalf through OverBlog API.
 *
 * The prerequisite is that you have registered your application at
 * OverBlog which gave you a consumer key and secret.
 */

include_once('../src/OverBlog.php');

// In this example we use a very simple store which is the session
// but in your application you may want to store user access tokens
// in a safer and long lasting store such as a database ;)

session_start();


// Here, replace consumerKey and consumerSecret with your data

$ob = new OverBlog (
	array (
		'consumerKey'		=> 'yourConsumerKey',
		'consumerSecret'	=> 'yourConsumerSecret',
	)
);


$self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

// Clear access token from session (unauthorize action)

if (isset($_GET['clear']))
{
	unset($_SESSION['accessToken']);
	unset($_SESSION['accessSecret']);
	unset($_SESSION['userId']);
}


// Do we already know the user access token ?

if (isset($_SESSION['accessToken']) && isset($_SESSION['accessSecret']) && isset($_SESSION['userId']))
{
	$ob->setAccessTokenAndSecret($_SESSION['accessToken'], $_SESSION['accessSecret']);

	echo "<h1>Authorization demonstration</h1>";
	echo "Hooray ! You are authorized at OverBlog !";

	echo "<h2>Your OAuth data</h2><pre>";
	print_r($_SESSION);
	echo "</pre>";

	echo "<h2>Your user data</h2><pre>";
	print_r($ob->getUserInfo());
	echo "</pre>";

	echo "<h2>Your blogs</h2><pre>";
	print_r($ob->getUserBlogs());
	echo "</pre>";

	echo "<h2>Unauthorize</h2>";
	echo '<a href="'.$self.'?clear=1">click here</a>';
	die();
}



// Is the user back from the authorize form located at OverBlog ?

if (isset($_GET['oauth_token']) &&
	isset($_GET['oauth_verifier']) &&
	isset($_SESSION['requestToken']) &&
	isset($_SESSION['requestSecret']))
{
	// exchange the request token with an access token
	$accessData = $ob->getAccessTokenFromRequestTokenAndVerifier (
		$_SESSION['requestToken'],
		$_SESSION['requestSecret'],
		$_GET['oauth_verifier']
	);

	// save this access token in the session store
	$_SESSION['accessToken'] = $accessData['oauth_token'];
	$_SESSION['accessSecret'] = $accessData['oauth_token_secret'];
	$_SESSION['userId'] = $accessData['user_id'];

	// remove the request token data from the session store
	unset($_SESSION['requestToken']);
	unset($_SESSION['requestSecret']);

	// finally, reload this page
	header('Location: ' . $self);
	die();
}
else
{
	// We are going to authorize a new request token
	// This method takes the callback URL as argument
	$requestData = $ob->getRequestTokenAndAuthorizeUrl ($self);

	// Save the request token in the session store
	// When authorized, we will exhange it with an access token
	$_SESSION['requestToken'] = $requestData['oauth_token'];
	$_SESSION['requestSecret'] = $requestData['oauth_token_secret'];

	// Prompt the user to go to OverBlog authorization form
	echo "<h1>Authorization demonstration</h1>";
	echo '<a href="'.$requestData['authorize_url'].'">authorize</a>';
}
