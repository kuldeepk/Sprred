<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="content_wrap" class="rounded5">
<div id="content">
	<div id="blog-content">
	<?php if($posts){
		foreach($posts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
		<div class="post">
			<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
			<div class="entry">
				<?php echo $postInfo->getBlogContent(); ?>
			</div>
			<div class="post_details">
				Posted <?php echo $postInfo->getPostedAgo(); ?> ago<br>
			</div>
		</div>
	<?php }	
	} else { ?>
		<div class='no-posts'><h2>No posts found</h2></div>
	<?php } ?>
		<div class="reset"></div>
	</div>
</div>

<?php require(dirname(__FILE__).'/sidebar.php'); ?>
<div class="reset"></div>
</div>

<?php require(dirname(__FILE__).'/footer.php'); ?>
