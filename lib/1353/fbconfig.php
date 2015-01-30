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

$helper = new FacebookCanvasLoginHelper();
try {
$session = $helper->getSession();
} catch (FacebookRequestException $ex) {
echo $ex->getMessage();
} catch (\Exception $ex) {
echo $ex->getMessage();
}
if ($session) {
try {
// $request = new FacebookRequest($session, 'GET', '/me');
// $response = $request->execute();
// $me = $response->getGraphObject();
// echo $me->getProperty('name');
// $postRequest = new FacebookRequest($session, 'POST', '/me/feed', array('link' => 'http://codenmind.com', 'description' => 'new description', 'message' => 'My first post using my facebook app.'));
// $postResponse = $postRequest->execute();
// $posting = $postResponse->getGraphObject();
// echo $posting->getProperty('id');
// uploading image to user timeline using facebook php sdk v4
$response = (new FacebookRequest(
$session, 'POST', '/me/photos', array(
'source' => new CURLFile('picture.jpg', 'image/jpg'),
'message' => 'User provided message'
)
)
)->execute()->getGraphObject();
if($response) {
echo "Done";
}
} catch(FacebookRequestException $e) {
echo $e->getMessage();
}
} else {
$helper = new FacebookRedirectLoginHelper('http://collap.com/lib/1353/fbconfig.php');
$auth_url = $helper->getLoginUrl(array('email', 'publish_actions'));
echo "<script>window.top.location.href='".$auth_url."'</script>";
?>
