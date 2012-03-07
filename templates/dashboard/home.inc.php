<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/classes/ViewPosts.class.php");
require_once(dirname(__FILE__)."/../../includes/classes/PostInfo.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php"); 
require_once(dirname(__FILE__)."/../../includes/lib/connect.lib.php");
require_once(dirname(__FILE__)."/../../includes/lib/twitter/twitteroauth/twitterOAuth.php");
/*************************************/

$info = new UserInfoDAO(Auth::getLoggedInID());

$view = new ViewPosts(Auth::getLoggedInID());

if($_GET['page'])
	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
else
	$page = 1;

$posts = $view->getAllPosts(10 , ($page-1)*10, array('public', 'private'));

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
}

if(!$isFBConnected){
	$facebook = new Facebook(array('cookie' => true));
	$fb_id = $facebook->getUser();
	$fb_session = $facebook->getSession();
	$userInfo = new UserInfoDAO(Auth::getLoggedInID());
	Connect::fbLinkNewUser(Auth::getLoggedInID(), $fb_id, $fb_session, true);
	$isFBConnected = $connect->getFBID();
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
	<?php 
}

?>

<div id="home">
	<?php if(!$posts) { ?>
	<div class="message">
		<h1>Welcome to Your Sprred!</h1>
		<p class="detail">
			This your 'Sprred Dashboard', where you can manage and publish your content. Use above 'Quick Upload' buttons to upload your content. Under 'Manage' tab you can manage or edit your uploaded content. 
		</p>
		<p class="detail">	
			Finally, click on 'View your Sprred' link above in the right corner to view your Sprred. 
		</p>
	</div>
	<?php } else { ?>
	<div id="news-feed">
		<ul class="small-menu">
			<li class="selected">Your Posts</li>
		</ul>
		<div id="feed">
		<?php foreach($posts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
			<div class="post">
				<h2 class="title"><a href="<?php echo $postInfo->getPostURL(Auth::getLoggedInID(), true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
				<div class="entry">
					<?php 
						if($post['type'] == 'blog')
							echo '<p class="desc">'. $postInfo->getPostDesc() .'</p>'; 
						else if($post['type'] == 'photo') {
							echo '<img src="'. $postInfo->getPhotoURL('m') .'" onclick="$(this).toggleClass(\'expanded\');">';
							echo '<p class="desc">'. $postInfo->getPostDesc() .'</p>'; 
						} else if($post['type'] == 'video') {
							echo '<div class="video-thumb" onclick="$(this).hide();$(this).next().show();"><img src="'. $postInfo->getVideoThumbURL('m') .'"><div class="play-icon"></div></div>';
							?>
							<div class="video">
								<object type="application/x-shockwave-flash" data="/swf/flashplayer.swf" style="outline: none;" width="410" height="250">
								    <param name="movie" value="/swf/flashplayer.swf"></param>
									<param name="allowFullScreen" value="true"></param>
								    <param name="FlashVars" value="url=<?php echo $postInfo->getVideoURL(); ?>&autoPlay=false&volume=70&showFullScreenButton=true" />
								</object>
							</div>
							<div class="reset"></div>
							<?php 
							echo '<p class="desc">'. $postInfo->getPostDesc() .'</p>'; 
						} else if($post['type'] == 'link') {
							echo '<a href="'. $post['content'] .'" target="_blank" class="link">'. $post['content'] .'</a>';
						}
					?>
				</div>
				<div class="post-details">
					<?php 
						if($post['type'] == 'blog')
							echo '<div class="text"></div>'; 
						else if($post['type'] == 'photo') {
							echo '<div class="photo"></div>';
						} else if($post['type'] == 'video') {
							echo '<div class="video"></div>';
						} else if($post['type'] == 'link') {
							echo '<div class="link"></div>';
						}
					?>
					Posted <?php echo $postInfo->getPostedAgo(); ?> ago<br>
				</div>
			</div>
		<?php } ?>
			<?php if($page>1){?>
			<a class="nav-link left" href="Javascript:void(0);" onclick="loadContent('home', null, 'page=<?php echo $page-1; ?>');">Newer Posts</a>
			<?php } 
			if(count($posts)==10){ ?>
			<a class="nav-link right" href="Javascript:void(0);" onclick="loadContent('home', null, 'page=<?php echo $page+1; ?>');">Older Posts</a>
			<?php } ?>	
		</div>		
	</div>
	<?php } ?>
	<div id="sidebar">
		<div id="profile-meta">
			<?php if($info->getFullName()!='Unknown'){ ?>
				<h1><?php echo $info->getFullName(); ?></h1>
			<?php } else { ?>
				<div class="update-form">
					<h2>Enter Your Name</h2>
					<p class="row"><label>Full Name</label><input type="text" id="fullname" class="text" value="<?php echo $info->getFullName();?>"></p>
					<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-name', 'fullname='+$('#fullname').val())"></p>
				</div>
			<?php } 
			if($info->getProfileName()=='Untitled') {?>
				<div class="update-form">
					<h2>Enter Sprred Title</h2>
					<p class="row"><label>Sprred Title</label><input type="text" id="sprred-title" class="text" value="<?php echo $info->getProfileName();?>"></p>
					<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-stitle', 'stitle='+$('#sprred-title').val())"></p>
				</div>
			<?php } 
			if(!$isFBConnected) { ?>
				<div class="update-form">
					<h2>Autopost to Facebook</h2>
					<p class="row"><a href="Javascript:void(0);" onclick="FB.login(fb_login, {perms:'publish_stream,offline_access'});" class="signin-with-facebook"></a></p>
				</div>
			<?php } if(!$isTwConnected) { ?>
				<div class="update-form">
					<h2>Autopost to Twitter</h2>
					<p class="row"><a href="Javascript:void(0);" onclick="twOAuthPop('<?php echo $request_link ?>');" class="signin-with-twitter"></a></p>
				</div>
			<?php } ?>
		</div>
		<div class="reset"></div>
		<!-- 
		<h2>Followers <label>(0)</label></h2>
		<div id="followers" class="follow">
			No Followers, yet.
		</div>
		<h2>Following <label>(0)</label></h2>
		<div id="following" class="follow">
			Not Following, yet.
		</div>
		 -->
		<div class="reset"></div>
	</div>
	<div class="reset"></div>
</div>