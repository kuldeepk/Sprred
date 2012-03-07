<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/db/Posts.db.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../../includes/classes/PostInfo.class.php");
/*************************************/

$info = new UserInfoDAO(Auth::getLoggedInID());

if($_GET['page'])
	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
else
	$page = 1;

$posts = PostsDB::getAllPosts(10, ($page-1)*10, null, "('public')");

?>

<div id="home">
	<div id="news-feed">
		<ul class="small-menu">
			<li class="selected">Your Posts</li>
		</ul>
		<div id="feed">
		<?php foreach($posts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
			<div class="post">
				<h2 class="title"><a href="<?php echo $postInfo->getPostURL($post['userID'], true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
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
	<div id="sidebar">
	</div>
	<div class="reset"></div>
</div>