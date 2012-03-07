<?php 

$blogPosts = $view->getAllBlogPosts(3, 0, array('public'));
$photosPosts = $view->getAllPhotos(8, 0, array('public'));
$videosPosts = $view->getAllVideos(8, 0, array('public'));
$links = $view->getAllLinks(5, 0, array('public'));

?>

<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="content_wrap" class="rounded5">
<div id="home-content">
	<?php if($blogPosts){ ?>
	<div id="blog-preview" class="preview">
		<h1>Blog</h1>
	<?php foreach($blogPosts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
		<div class="post">
			<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
			<div class="entry">
				<?php echo $postInfo->getPostDesc(); ?> 
			</div>
			<div class="post_details">
				Posted <?php echo $postInfo->getPostedAgo(); ?> ago
				<a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>" class="more">Read More</a>
			</div>
		</div>
	<?php }	?>
		<div class="reset"></div>
	</div>
	<?php } ?>
	
	<?php if($photosPosts){ ?>
	<div id="photos-preview" class="preview">
		<h1>Photos</h1>
	<?php foreach($photosPosts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
			<div class="photo-entry">
				<div class="entry">
					<div class="img-wrap">
						<a href="<?php echo $post['postLink']; ?>">
							<img src="<?php echo $postInfo->getPhotoURL('s'); ?>" class="image">
						</a>
					</div>
				</div>
			</div>
	<?php }	?>
		<div class="reset"></div>
	</div>
	<?php } ?>
	
	<?php if($videosPosts){ ?>
	<div id="videos-preview" class="preview">
		<h1>Videos</h1>
	<?php foreach($videosPosts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
			<div class="videos-entry">
				<div class="entry">
					<div class="img-wrap">
						<a href="<?php echo $post['postLink']; ?>">
							<img src="<?php echo $postInfo->getVideoThumbURL('s'); ?>" class="image">
							<div class="play-icon"></div>
						</a>
					</div>
				</div>
			</div>
	<?php }	?>
		<div class="reset"></div>
	</div>
	<?php } ?>
	
	<?php if($links){ ?>
	<div id="videos-preview" class="preview">
		<h1>Links</h1>
	<?php foreach($links as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
			<div class="post">
				<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
				<div class="entry">
					<a href="<?php echo $postInfo->getPostURL($userID, true); ?>" class="link"><?php echo $postInfo->getPostURL($userID, true); ?></a>
				</div>
				<div class="post_details">
					Posted <?php echo $postInfo->getPostedAgo(); ?> ago<br>
				</div>
			</div>
	<?php }	?>
		<div class="reset"></div>
	</div>
	<?php } ?>
	<?php if(!$blogPosts && !$photosPosts && !$videosPosts && !$links) { ?>
		<div class='no-posts'><h2>No posts found</h2></div>
	<?php } ?>
</div>

<?php require(dirname(__FILE__).'/sidebar.php'); ?>
<div class="reset"></div>
</div>

<?php require(dirname(__FILE__).'/footer.php'); ?>
