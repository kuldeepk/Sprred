<?php
session_start();
/* Include Files *********************/
require_once("../../conf/config.inc");
require_once("../../import/fbconnect/fbconfig.php");
require_once("../../import/fbconnect/facebookapi_php5_restlib.php");
require_once("../../import/fbconnect/facebook.php");
/*************************************/

$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');
//$GLOBALS["fb"] = $fb;
//$fb->kill_cookies();
//unset($fb->user);
//$fb->require_frame();
//$user = $fb->require_login();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script>
		$(document).ready(function() {
			FB.init("75cfded145be7acba7bde74cc230fd3b","xd_receiver.htm", {
				"ifUserConnected": reload_page2
			});
		});
		</script>
	</head>
<body>
	<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<div id="comments_post">
  <form method="POST">
  	<div id="user">
	<?php
		$fb_user_id = $fb->get_loggedin_user();
		if($fb_user_id){
			try {
				$info = $fb->api_client->users_getInfo($fb_user_id,"name,pic_big,about_me,birthday,current_location");
				echo "My name is <b> {$info[0]['name']} </b>";
				echo "My about me is <b> {$info[0]['about_me']} </b>";
				echo "My birthday is on <b> {$info[0]['birthday']} </b>";
				echo "My current location is <b> {$info[0]['current_location'][city]} </b>";
				$picurl=$info[0]['pic_big'];
				echo '<img src="'. $picurl .'">';			
				echo '<br><div class="white"><fb:login-button size="medium" background="white" length="long" onlogin="reload_page();"></fb:login-button></div>';
			} catch(Exception $e) {
				echo '<div class="white"><fb:login-button onlogin="reload_page();"></fb:login-button></div>';
			}			
		} else {
			echo '<div class="white"><fb:login-button onlogin="reload_page();"></fb:login-button></div>';			
		}
	?>
	</div>
  </form>
	<!--<a href="#" onclick='FB.Connect.logoutAndRedirect("logout.php")'>Logout</a><br> -->
	<a href="#" onclick='logout_btn();'>Logout</a><br>
</div>
<script type="text/javascript">
function reload_page() {
	var user = FB.Facebook.apiClient.get_session().uid;
	if(!user){
		alert('Sorry, we were unable to determine your Facebook user ID and sign you in.');
		return;
	}
	else
		alert(user);
	//FB.Connect.ifUserConnected("/home.php", null)
	window.location.reload();
}

function reload_page2() {
	var user = FB.Facebook.apiClient.get_session().uid;
	if(!user){
		alert('Sorry, we were unable to determine your Facebook user ID and sign you in.');
		return;
	}
	else
		alert(user);
}

function logout_btn() {
    /*
var session = FB.Facebook.apiClient.get_session();
    var user = session ? session.uid : null;
    var singleton = FB.Connect._singleton;
    var nextUrl = FBIntern.Uri.addQueryParameters(
      FB.XdComm.Server.singleton.get_receiverUrl(),
      'fb_login&fname=_parent&session=loggedout'
    );
    singleton._ensureLoginHandler();
    singleton._logoutCallback = "..."; // <-- wherever you want to go after logout
    logoutUrl = FBIntern.Utility.getFacebookUrl('www');
    logoutUrl += 'logout.php?app_key=' + FB.Facebook.apiKey;
    logoutUrl += '&session_key=' + encodeURIComponent(
      session.session_key
    ) + '&next=' + encodeURIComponent(nextUrl);
    FB.Facebook.apiClient.set_session(null);
    singleton.set__userInfo(null);
    singleton._logoutIframe = FB.XdComm.Server.singleton.createNamedHiddenIFrame(
      'fbLogout',
      logoutUrl,
      'fb_logout',
      null
    );
	window.location = 'logout.php';
*/
	FB.ensureInit( function(){ FB.Connect.logout(); });
}
</script>
<script type="text/javascript">
      
</script>
</body>
</html>