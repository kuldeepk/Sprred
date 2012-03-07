<?php 

$postInfo = new PostInfo($post);

?>

<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="content_wrap" class="rounded5">
<div id="photo-content">
	<?php if($postInfo){ ?>
		<div class="post">
			<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
			<div class="entry">
				<?php 
					echo '<img src="'. $postInfo->getPhotoURL('n') .'">';
					echo '<p class="desc">'. $postInfo->getPostDesc() .'</p>'; 
				?>
			</div>
			<div class="post_details">
				Posted <?php echo $postInfo->getPostedAgo(); ?> ago<br>
			</div>
			<div class="share-links photo-share">
				<div class="tw-share"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="Sprred">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
				<div class="fb-share"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($postInfo->getPostURL($userID, false)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe></div>
				<div class="reset"></div>
			</div>
		</div>
	<?php 	
	} else { ?>
		<div class="message">Photo not found!</div>
	<?php } ?>
		<div class="reset"></div>
</div>

<div id="photo-sidebar">
	<?php
		if($post){ ?>
			<div class="set"><div onclick="$(this).next().next().toggle();if($(this).html()=='-'){$(this).html('+');}else{$(this).html('-');}$(this).toggleClass('expanded');" class="toggle expanded">-</div>
			<h2><a href="<?php echo $info->getProfileURL(); ?>/photos">Photostream</a></h2>
			<div class="set-content">
		<?php $postInfo = new PostInfo($post);
			$posts = $postInfo->getLatestPhotos($userID, 2);
			if($posts){
				foreach($posts as $key=>$entry){
					$entryInfo = new PostInfo($entry);
					?>
					<div class="item">
						<div class="image">
							<a href="<?php echo $entryInfo->getPostURL($userID, true); ?>"><img src="<?php echo $entryInfo->getPhotoURL('xs'); ?>"></a>
						</div>
						<h3><a href="<?php echo $entryInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $entryInfo->getPostTitle(); ?>"><?php echo $entryInfo->getPostTitle(); ?></a></h3>
						<div class="post-meta">Posted <?php echo $entryInfo->getPostedAgo(); ?> ago</div>
						<div class="reset"></div>
					</div>
			<?php } 
			} ?>
			<div class="item current">
				<div class="image">
					<a href="<?php echo $postInfo->getPostURL($userID, true); ?>"><img src="<?php echo $postInfo->getPhotoURL('xs'); ?>"></a>
				</div>
				<h3><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h3>
				<div class="post-meta">Posted <?php echo $postInfo->getPostedAgo(); ?> ago</div>
				<div class="reset"></div>
			</div>
			<?php $posts = $postInfo->getOlderPhotos($userID, 2);
			if($posts){
				foreach($posts as $key=>$entry){
					$entryInfo = new PostInfo($entry);
					?>
					<div class="item">
						<div class="image">
							<a href="<?php echo $entryInfo->getPostURL($userID, true); ?>"><img src="<?php echo $entryInfo->getPhotoURL('xs'); ?>"></a>
						</div>
						<h3><a href="<?php echo $entryInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $entryInfo->getPostTitle(); ?>"><?php echo $entryInfo->getPostTitle(); ?></a></h3>
						<div class="post-meta">Posted <?php echo $entryInfo->getPostedAgo(); ?> ago</div>
						<div class="reset"></div>
					</div>
			<?php }
			}
			echo '</div></div>';
		} ?>
</div>

<div class="reset"></div>
</div>

<?php require(dirname(__FILE__).'/footer.php'); ?>
