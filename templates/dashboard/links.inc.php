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
$posts = $viewPosts->getAllLinks(15, ($page-1)*15, array('public', 'draft', 'private'));

if(!$posts){
	echo "<div class='no-posts'><h2>No posts found</h2></div>";
	exit(0);
}
?>

<ul id="links">
	<h1>Manage Your Links</h1>
<?php
	foreach($posts as $key=>$post){ ?>	
		<li class="post rounded3">
			<a href="<?php echo $post['content']; ?>" target="_blank" class="title"><?php echo $post['title']; ?></a>
			<a href="<?php echo $post['content']; ?>" target="_blank" class="link"><?php echo $post['content']; ?></a>
			<div class="bottom-line">
				<label class="pubtime"><?php echo Utility::time_since((int) $post['pubtime']); ?> ago</label>
				<label class="seperator">|</label>
				<label class="trash" onclick="delPost('<?php echo $post['postID']; ?>', $(this).parent().parent());"></label>
				<div class="reset"></div>
			</div>
			<div class="reset"></div>
		</li>
<?php } ?>
	<?php if($page>1){?>
	<a class="nav-link left" href="Javascript:void(0);" onclick="loadContent('manage/links', null, 'page=<?php echo $page-1; ?>');">Newer Posts</a>
	<?php } 
	if(count($posts)==15){ ?>
	<a class="nav-link right" href="Javascript:void(0);" onclick="loadContent('manage/links', null, 'page=<?php echo $page+1; ?>');">Older Posts</a>
	<?php } ?>
<div class="reset"></div>
</ul>
