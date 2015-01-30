<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '235401549997398','dc5cb7d9ca7b4122a1446fe271957b93' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://collap.com/lib/1353/fbconfig.php' );// see if a existing session exists
if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
// create new session from saved access_token
$session = new FacebookSession( $_SESSION['fb_token'] );
// validate the access_token to make sure it's still valid
try {
if ( !$session->validate() ) {
$session = null;
}
} catch ( Exception $e ) {
// catch any exceptions
$session = null;
}
}
if ( !isset( $session ) || $session === null ) {
// no session exists
try {
$session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
// When Facebook returns an error
// handle this better in production code
print_r( $ex );
} catch( Exception $ex ) {
// When validation fails or other local issues
// handle this better in production code
print_r( $ex );
}
}
// see if we have a session
if ( isset( $session ) ) {
// save the session
$_SESSION['fb_token'] = $session->getToken();
// create a session using saved token or the new one we generated at login
$session = new FacebookSession( $session->getToken() );
// graph api request for user data
$request = new FacebookRequest( $session, 'GET', '/me' );
$response = $request->execute();
// get response
$graphObject = $response->getGraphObject()->asArray();
// print profile data
echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
// print logout url using session and redirect_uri (logout.php page should destroy the session)
echo '<a href="' . $helper->getLogoutUrl( $session, 'logout.php' ) . '">Logout</a>';
} else {
// show login url
echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
} 
