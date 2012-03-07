<?php
//session_start();
/* Include Files *********************/
require_once("../../conf/config.inc");
require_once("../../import/fbconnect/fbconfig.php");
require_once("../../import/fbconnect/facebook.php");
/*************************************/

$fb = new Facebook($fb_api_key, $fb_secret);
//$fb->require_frame();
//$user = $fb->require_login();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<body>
	<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<div id="comments_post">
  <h3>Leave a comment:</h3>
  <form method="POST">
  	<div id="user">
	<?php
		$fb_user_id = $fb->get_loggedin_user();
		//if($fb_user_id){
			$info = $fb->api_client->users_getInfo($fb_user_id,"name,pic_big,about_me,birthday,current_location");
			echo "My name is <b> {$info[0]['name']} </b>";
			echo "My about me is <b> {$info[0]['about_me']} </b>";
			echo "My birthday is on <b> {$info[0]['birthday']} </b>";
			echo "My current location is <b> {$info[0]['current_location']} </b>";
			$picurl=$info[0]['pic_big'];
			echo $picurl;
		//} else {
		//	echo '<fb:login-button onlogin="update_user_box();"></fb:login-button>';
		//}
	?>
	</div>
  </form>	
</div>
<script type="text/javascript">
function update_user_box() {

  var user_box = document.getElementById("user");

  // add in some XFBML. note that we set useyou=false so it doesn't display "you"
  user_box.innerHTML =
      "<span>"
    + "<fb:profile-pic uid=loggedinuser facebook-logo=true></fb:profile-pic>"
    + "Welcome, <fb:name uid=loggedinuser useyou=false></fb:name>. You are signed in with your Facebook account."
    + "</span>";

  // because this is XFBML, we need to tell Facebook to re-process the document 
  FB.XFBML.Host.parseDomTree();
  //FB.Connect.ifUserConnected(alert('hi'));
}
</script>
<script type="text/javascript">
   FB.init("75cfded145be7acba7bde74cc230fd3b","xd_receiver.htm");
   
</script>
</body>
</html>