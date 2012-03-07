<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="content_wrap" class="rounded5">
	<div id="videos-content">
	<?php if($posts){
		foreach($posts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			?>
		<div class="videos-entry">
			<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
			<div class="entry">
				<div class="img-wrap">
					<a href="<?php echo $post['postLink']; ?>">
						<img src="<?php echo $postInfo->getVideoThumbURL('s'); ?>" class="image">
						<div class="play-icon"></div>
					</a>
				</div>
				<div class="desc">
					<?php echo $postInfo->getPostDesc(); ?>
				</div>
			</div>
			<small class="postmetadata">Uploaded <?php echo $postInfo->getPostedAgo(); ?> ago</small>
		</div>

	<?php }	
	} else { ?>
		<div class='no-posts'><h2>No posts found</h2></div>
	<?php } ?>
		<div class="reset"></div>
	</div>
	<div class="reset"></div>
</div>

<?php require(dirname(__FILE__).'/footer.php'); ?>