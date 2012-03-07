<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../includes/lib/twitter/twitteroauth/twitterOAuth.php");
require_once(dirname(__FILE__)."/../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../includes/lib/twitter/tw-connect-oauth.lib.php");
require_once(dirname(__FILE__)."/../includes/lib/connect.lib.php");
/*************************************/

$title = '<title>Sprred - Re-directing</title>';

$action = null;

if ($_REQUEST['oauth_token'] != NULL && $_SESSION['oauth_state'] === 'start') {/*{{{*/
	if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
		/* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
		$to = new TwitterOAuth($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
		/* Request access tokens from twitter */
		$tok = $to->getAccessToken();
		
		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['oauth_access_token'] = $tok['oauth_token'];
		$_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
    }

	$twConnect = new TwConnectOAuth($_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
	if($twConnect->verifyUser()) {
		$auth = new Auth();
		if($auth->checkLogin()){
			Connect::twLinkUser($_SESSION['userId'], $twConnect->getTwUsername(), $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret'], true);
			$action = 'window.opener.location.reload();';
			unset($_SESSION['oauth_access_token']);
			unset($_SESSION['oauth_access_token_secret']);
			unset($_SESSION['oauth_request_token']);
			unset($_SESSION['oauth_request_token_secret']);
			unset($_SESSION['oauth_state']);
		} else {
			$result = $auth->login($_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret'], 'twitter');
			if($result != 0){
				$_SESSION['tw-uname'] = $twConnect->getTwUsername();
				$_SESSION['twObj'] = &$twConnect;
				$action = 'window.opener.location="/reg-connect.php";';
				unset($_SESSION['oauth_request_token']);
				unset($_SESSION['oauth_request_token_secret']);
				unset($_SESSION['oauth_state']);
			} else {
				$action = 'window.opener.location="/dashboard";';
				unset($_SESSION['oauth_access_token']);
				unset($_SESSION['oauth_access_token_secret']);
				unset($_SESSION['oauth_request_token']);
				unset($_SESSION['oauth_request_token_secret']);
				unset($_SESSION['oauth_state']);
			}
		}
	}
}


$header = '<script>
$(document).ready(function(){
	'.$action.'
	window.close();
});
</script>';

?>

<?php include("../templates/header.inc.php"); ?>

	<div id="contents">
		<div id="loading">
			<p>Redirecting...</p>
		</div>
	</div> <!--contents-->
	
<?php include("../templates/footer.inc.php"); ?>