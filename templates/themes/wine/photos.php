<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="photos-content">
	<?php if($posts){
		foreach($posts as $key=>$post){ 
			$postInfo = new PostInfo($post);
			if($key==0 || !($key%3)) echo '<div class="row">';
			?>
		<div class="photo-post media-post <?php if(!(($key+1)%3)) echo 'last'; ?>">
			<h1><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h1>
			<div class="entry">
				<div class="img-wrap">
					<a href="<?php echo $post['postLink']; ?>">
						<img src="<?php echo $postInfo->getPhotoURL('s'); ?>" class="image">
					</a>
				</div>
				<div class="desc">
					<?php echo $postInfo->getPostDesc(); ?>
				</div>
			</div>
			<div class="post_details">Uploaded <?php echo $postInfo->getPostedAgo(); ?> ago</div>
		</div>

	<?php 
			if(!(($key+1)%3)) echo '<div class="reset"></div></div>';
		}	
	} else { ?>
		<div class='no-posts'><h2>No posts found</h2></div>
	<?php } ?>
		<div class="reset"></div>
</div>
<div class="reset"></div>

<?php require(dirname(__FILE__).'/footer.php'); ?>