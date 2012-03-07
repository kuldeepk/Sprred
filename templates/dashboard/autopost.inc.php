<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php"); 
require_once(dirname(__FILE__)."/../../includes/lib/connect.lib.php");
require_once(dirname(__FILE__)."/../../includes/lib/twitter/twitteroauth/twitterOAuth.php");
/*************************************/

$connect = new ConnectDAO(Auth::getLoggedInID());
$isTwConnected = $connect->getTWAccessTkn();
$isFBConnected = $connect->getFBID();
if(!$isTwConnected) {
	$to = new TwitterOAuth();
    /* Request tokens from twitter */
    $tok = $to->getRequestToken();
	/* Save tokens for later */
    $_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
    $_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
    $_SESSION['oauth_state'] = "start";	
    /* Build the authorization URL */
    $request_link = $to->getAuthorizeURL($token);
	echo '<script>
	function twOAuthPop(url) {
		var windowprops ="width=800px,height=400px,top=100px,left=200px,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no";
		window.open(url,"",windowprops);
	}
	</script>';
} else {
	$isTwAutopost = $connect->isTwAutopost();
}

if(!$isFBConnected){
	$facebook = new Facebook(array('cookie' => true));
	$fb_id = $facebook->getUser();
	$fb_session = $facebook->getSession();
	$userInfo = new UserInfoDAO(Auth::getLoggedInID());
	Connect::fbLinkNewUser(Auth::getLoggedInID(), $fb_id, $fb_session, true);
	$isFBConnected = $connect->getFBID();
} else {
	$isFBAutopost = $connect->isFBAutopost();
	$fbPhotosMethod = $connect->getFBPhotosMethod();
	$fbVideosMethod = $connect->getFBVideosMethod();
}

?>

<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
  FB.init({appId: '201605335409', status: true, cookie: true, xfbml: true});
  FB.Event.subscribe('auth.sessionChange', function(response) {
    if (response.session) {
      // A user has logged in, and a new cookie has been saved
        window.reload();
    } else {
      // The user has logged out, and the cookie has been cleared
    }
  });
  function fb_login(response) {
	  if (response.session) {
		    if (response.perms) {
		      // user is logged in and granted some permissions.
		      // perms is a comma separated list of granted permissions
		    	 window.reload();
		    } else {
		      // user is logged in, but did not grant any permissions
		    }
		  } else {
		    // user is not logged in
		  }
		}
</script>
<div id="autopost">
	<h1>Autoposting Options</h1>
	<ul class="services-list">
		<li class="rounded5">
			<label class="name" id="fb-icon">Facebook</label>
			<?php if(!$isFBConnected) { ?>
				<label class="status"><a href="Javascript:void(0);" onclick="FB.login(fb_login, {perms:'publish_stream,offline_access'});" class="signin-with-facebook"></a></label>
			<?php } else { ?>
				<label class="configure" onclick="$(this).parent().toggleClass('selected');$('#fb-options').slideToggle('fast');">Configure</label>
				<label class="unlink" onclick="unlinkService('facebook');">Unlink</label>
				<?php if($isFBAutopost){ ?>
				<label class="status">Enabled</label>
				<?php } else {?>
				<label class="status">Disabled</label>
				<?php } ?>
			<div class="reset"></div>
			<form id="fb-options" class="options update-form" style="display:none;">
				<p class="row">
					<label>Autoposting: </label>
					<div class="input-group">
						<input type="radio" name="fb-status" id="fb-status-en" value="enable" <?php if($isFBAutopost){ echo 'checked="checked"'; }?>><label for="fb-status-en">Enable</label>
						<input type="radio" name="fb-status" id="fb-status-dis" value="disable" <?php if(!$isFBAutopost){ echo 'checked="checked"'; }?>><label for="fb-status-dis">Disable</label>
					</div>
					<div class="reset"></div>
				</p>
				<p class="row">
					<label>Post photos as: </label>
					<select name="fb-photos-method" class="drop-down">
						<option value="album" <?php if($fbPhotosMethod == 'album'){ echo 'selected="selected"'; }?>>Facebook Photos</option>
						<option value="status" <?php if($fbPhotosMethod == 'status'){ echo 'selected="selected"'; }?>>Facebook Status</option>
					</select>
				</p>
				<!-- <p class="row">
					<label>Post videos as: </label>
					<select name="fb-videos-method" class="drop-down">
						<option value="album" <?php if($fbVideosMethod == 'album'){ echo 'selected="selected"'; }?>>Facebook Videos</option>
						<option value="status" <?php if($fbVideosMethod == 'status'){ echo 'selected="selected"'; }?>>Facebook Status</option>
					</select>
				</p> -->
				<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-fb-options', $('form#fb-options').serialize(), true);$(this).parent().parent().parent().toggleClass('selected');$('#fb-options').slideToggle('fast');"></p>
			</form>
			<?php } ?>
			<div class="reset"></div>
		</li>
		<li class="rounded5">
			<label class="name" id="tw-icon">Twitter</label>
			<?php if(!$isTwConnected) { ?>	
			<label class="status"><a href="Javascript:void(0);" onclick="twOAuthPop('<?php echo $request_link ?>');" class="signin-with-twitter"></a></label>
			<?php } else { ?>
			<label class="configure" onclick="$(this).parent().toggleClass('selected');$('#tw-options').slideToggle('fast');">Configure</label>
			<label class="unlink" onclick="unlinkService('twitter');">Unlink</label>
				<?php if($isTwAutopost){ ?>
				<label class="status">Enabled</label>
				<?php } else {?>
				<label class="status">Disabled</label>
				<?php } ?>
			<div class="reset"></div>
			<form id="tw-options" class="options update-form" style="display:none;">
				<p class="row">
					<label>Autoposting: </label>
					<div class="input-group">
						<input type="radio" name="tw-status" id="tw-status-en" value="enable" <?php if($isTwAutopost){ echo 'checked="checked"'; }?>><label for="tw-status-en">Enable</label>
						<input type="radio" name="tw-status" id="tw-status-dis" value="disable" <?php if(!$isTwAutopost){ echo 'checked="checked"'; }?>><label for="tw-status-dis">Disable</label>
					</div>
					<div class="reset"></div>
				</p>
				<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-tw-options', $('form#tw-options').serialize(), true);$(this).parent().parent().parent().toggleClass('selected');$('#tw-options').slideToggle('fast');"></p>
			</form>
			<?php } ?>
			<div class="reset"></div>
		</li>
	</ul>
	<div class="note">
		Link your other accounts by signing up here and every time you post anything on your Sprred, it gets autoposted on your linked account. After linking your accounts you can configure the autoposting options or disable the service here.
	</div>
</div>