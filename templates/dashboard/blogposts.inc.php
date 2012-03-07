<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/classes/ViewPosts.class.php");
/*************************************/

$viewPosts = new ViewPosts(Auth::getLoggedInID());
if($_GET['page'])
	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
else
	$page = 1;
$posts = $viewPosts->getAllBlogPosts(15, ($page-1)*15, array('public', 'draft', 'private'));

if(!$posts){
	echo "<div class='no-posts'><h2>No posts found</h2></div>";
	exit(0);
}

?>

<ul id="blog-posts">
	<li id="theader" class="post"><div class="col0"><input type="checkbox" name="master-check" onclick="if($(this).is(':checked')){ $('.post input:checkbox').attr('checked', true); } else { $('.post input:checkbox').attr('checked', false); }"></div><div class="col1">Title</div><div class="col2">Status</div><div class="col3">Time</div><div class="reset"></div></li>
<?php
	foreach($posts as $key=>$post){ ?>
		<li class="post rounded3">
			<div class="col0"><input type="checkbox" name="post-row row-<?php echo $key; ?>" class="post-row row-<?php echo $key; ?>"></div>
			<div class="col1"><a href="Javascript:void(0);" class="title" onclick="showPostEditor('<?php echo $post['s3name']; ?>', $(this).parent().parent(), <?php echo $key; ?>);"><?php echo $post['title']; ?></a></div>
			<div class="col2"><label class="status"><?php echo $post['status']; ?></label></div>
			<div class="col3"><label class="pubtime"><?php echo Utility::time_since((int) $post['pubtime']); ?> ago</label></div>
			<div class="col4"><div class="trash" onclick="delPost('<?php echo $post['postID']; ?>', $(this).parent().parent());"></div></div>
			<div class="col5"><div class="edit" onclick="showPostEditor('<?php echo $post['s3name']; ?>', $(this).parent().parent(), <?php echo $key; ?>);">&darr;</div></div>
			<div class="reset"></div>
			<div class="loading">Loading...</div>
			<form class="post-box" id="post-box-<?php echo $key; ?>">
				<div class="main-boxes">
					<p class="caption">Title</p>
					<p class="input"><input type="text" id="post-title" class="title text" name="title" value="<?php echo $post['title']; ?>"></p>
					<p class="caption">Text</p>
					<p class="input"><textarea id="post-content-<?php echo $key; ?>" class="wysiwyg"></textarea></p>
					<input type="button" value="Update" class="sub-button" onclick="editPost('edit-blog-post', $('form#post-box-<?php echo $key; ?>').serialize()+'&content='+urlencode($('#blog-posts').data('editors')['post-content-<?php echo $key; ?>'].get_content())+'&postID=<?php echo $post['postID']; ?>');">
				</div>
				<div class="post-options">
					<p class="caption">Post Options</p>
					<p class="input">
						<select class="drop-down status" name="text-publish-option">
							<option value="now" <?php if($post['status'] == 'public'){ ?> selected="selected" <?php } ?>>Publish</option>
							<option value="save" <?php if($post['status'] == 'draft'){ ?> selected="selected" <?php } ?>>Save as a Draft</option>
							<option value="private" <?php if($post['status'] == 'private'){ ?> selected="selected" <?php } ?>>Private</option>
						</select>
					</p>
					<p class="caption">Tags</p>
					<p class="input"><textarea id="tags" name="text-tags"><?php echo $post['tags']; ?></textarea></p>
				</div>
				<div class="reset"></div>
			</form>
		</li>
<?php } ?>
	<?php if($page>1){?>
	<a class="nav-link left" href="Javascript:void(0);" onclick="loadContent('manage/blog', null, 'page=<?php echo $page-1; ?>');">Newer Posts</a>
	<?php } 
	if(count($posts)==15){ ?>
	<a class="nav-link right" href="Javascript:void(0);" onclick="loadContent('manage/blog', null, 'page=<?php echo $page+1; ?>');">Older Posts</a>
	<?php } ?>
<div class="reset"></div>
</ul>
