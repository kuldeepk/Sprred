<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/classes/ViewPosts.class.php");
require_once(dirname(__FILE__)."/../../includes/classes/PostInfo.class.php");
/*************************************/

$viewPosts = new ViewPosts(Auth::getLoggedInID());
if($_GET['page'])
	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
else
	$page = 1;
$posts = $viewPosts->getAllVideos(50, ($page-1)*50, array('public', 'draft', 'private'));

if(!$posts){
	echo "<div class='no-posts'><h2>No posts found</h2></div>";
	exit(0);
}
?>

<ul id="videos-list" class="media-list">
	<h1>Manage Your Videos</h1>
<?php
	foreach($posts as $key=>$post){ 
		$postInfo = new PostInfo($post);
		?>	
		<li class="post">
			<!--<div class="col0"><input type="checkbox" name="post-row row-<?php echo $key; ?>" class="post-row row-<?php echo $key; ?>"></div>-->
			<label class="caption">Title</label>
			<div class="close" onclick="$(this).parent().removeClass('selected');$(this).parent().addClass('post');"></div>
			<div class="reset"></div>
			<div class="title"><input type="text" class="text" name="title" value="<?php echo $post['title']; ?>"></div>
			<div class="reset"></div>
			<div class="image" onclick="$(this).parent().removeClass('post');$(this).parent().addClass('selected');">
				<img src="/images/image.php?url=<?php echo urlencode(substr($post['content'], 0, -4)."_0000.png"); ?>&size=s">
				<div class="play-icon"></div>
				<div class="reset"></div>
			</div>
			<div class="video">
				<object type="application/x-shockwave-flash" data="/swf/flashplayer.swf" style="outline: none;" width="410" height="250">
				    <param name="movie" value="/swf/flashplayer.swf"></param>
					<param name="allowFullScreen" value="true"></param>
				    <param name="FlashVars" value="url=<?php echo $post['content']; ?>&autoPlay=false&volume=70&showFullScreenButton=true" />
				</object>
			</div>
			<div class="reset"></div>
			<label class="caption">Description</label>
			<div class="desc"><textarea name="desc"><?php echo $post['desc']; ?></textarea></div>
			<div class="reset"></div>
			<label class="caption">Tags</label>
			<div class="tags"><input type="text" class="text" name="tags" value="<?php echo $post['tags']; ?>"></div>
			<div class="reset"></div>
			<div class="status-radios">
				<input type="radio" name="video-publish-option-<?php echo $post['postID']; ?>" value="now" <?php if($post['status'] == 'public'){ ?> checked="checked" <?php } ?>> <label class="label">Publish</label>
				<input type="radio" name="video-publish-option-<?php echo $post['postID']; ?>" value="save" <?php if($post['status'] == 'draft'){ ?> checked="checked" <?php } ?>> <label class="label">Save as a Draft</label>
				<input type="radio" name="video-publish-option-<?php echo $post['postID']; ?>" value="private" <?php if($post['status'] == 'private'){ ?> checked="checked" <?php } ?>> <label class="label">Private</label>
			</div>
			<input type="button" value="Update" class="sub-button" onclick="editPost('edit-video-post', 'title='+$(this).parent().find('input[name=\'title\']').val()+'&desc='+$(this).parent().find('textarea[name=\'desc\']').val()+'&video-publish-option='+$(this).parent().find('input:radio[name=\'video-publish-option-<?php echo $post['postID']; ?>\']:checked').val()+'&video-tags='+$(this).parent().find('input[name=\'tags\']').val()+'&postID=<?php echo $post['postID']; ?>');">
			<div class="reset"></div>
			<div class="status">
				<?php if($post['status'] == 'public'){ ?><label class="public"></label><?php } ?>
				<?php if($post['status'] == 'draft'){ ?><label class="save"></label><?php } ?>
				<?php if($post['status'] == 'private'){ ?><label class="private"></label><?php } ?>
			</div>
			<div class="pubtime"><label class=""><?php echo $postInfo->getPostedAgo(); ?> ago</label></div>
			<div class="trash" onclick="delPost('<?php echo $post['postID']; ?>', $(this).parent());"></div>
			<div class="reset"></div>
		</li>
<?php } ?>
	<?php if($page>1){?>
	<a class="nav-link left" href="Javascript:void(0);" onclick="loadContent('manage/videos', null, 'page=<?php echo $page-1; ?>');">Newer Posts</a>
	<?php } 
	if(count($posts)==50){ ?>
	<a class="nav-link right" href="Javascript:void(0);" onclick="loadContent('manage/videos', null, 'page=<?php echo $page+1; ?>');">Older Posts</a>
	<?php } ?>
<div class="reset"></div>
</ul>
