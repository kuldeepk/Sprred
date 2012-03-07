<?php 

$postInfo = new PostInfo($post);

?>

<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="video-post">
<?php if($postInfo){ ?>
	<div id="video-header">
		<div class="video-info">
			<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
			<div class="post-meta">
				Posted <?php echo $postInfo->getPostedAgo(); ?> ago<br>
			</div>
		</div>
		<div class="share-links video-share">
			<div class="tw-share"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="Sprred">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
			<div class="fb-share"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($postInfo->getPostURL($userID, false)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe></div>
			<div class="reset"></div>
		</div>
		<div class="reset"></div>
	</div>
	<div id="video-entry">
		<div class="video">
			<object type="application/x-shockwave-flash" data="/swf/flashplayer.swf" style="outline: none;" width="640" height="390">
			    <param name="movie" value="/swf/flashplayer.swf"></param>
				<param name="allowFullScreen" value="true"></param>
			    <param name="FlashVars" value="url=<?php echo $postInfo->getVideoURL(); ?>&autoPlay=true&volume=70&showFullScreenButton=true" />
			</object>
			<div onclick="$('#dark-out').toggle();$(this).toggleClass('on');" class="light-switch"></div>
			<div id="dark-out" onclick="$(this).toggle();"></div>
			<div class="reset"></div>
		</div>
	</div>
	<div id="video-desc">
		<p class="desc"><?php echo $postInfo->getPostDesc(); ?></p>
	</div>
<?php 	
} else { ?>
	<div class="message">Video not found!</div>
<?php } ?>
	<div class="reset"></div>
</div>
	
<div id="video-content">	
</div>

<div id="video-sidebar">
	<?php
		if($post){ ?>
			<div class="set">
				<div onclick="$(this).next().next().toggle();if($(this).html()=='-'){$(this).html('+');}else{$(this).html('-');}$(this).toggleClass('expanded');" class="toggle expanded">-</div>
				<h2><a href="<?php echo $info->getProfileURL(); ?>/photos">Videostream</a></h2>
				<div class="set-content">
		<?php $postInfo = new PostInfo($post);
			$posts = $postInfo->getLatestVideos($userID, 2);
			if($posts){
				foreach($posts as $key=>$entry){
					$entryInfo = new PostInfo($entry);
					?>
					<div class="item">
						<div class="image">
							<a href="<?php echo $entryInfo->getPostURL($userID, true); ?>"><img src="<?php echo $entryInfo->getVideoThumbURL('xs'); ?>"></a>
						</div>
						<h3><a href="<?php echo $entryInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $entryInfo->getPostTitle(); ?>"><?php echo $entryInfo->getPostTitle(); ?></a></h3>
						<div class="post-meta">Posted <?php echo $entryInfo->getPostedAgo(); ?> ago</div>
						<div class="reset"></div>
					</div>
			<?php } 
			} ?>
			<div class="item current">
				<div class="image">
					<a href="<?php echo $postInfo->getPostURL($userID, true); ?>"><img src="<?php echo $postInfo->getVideoThumbURL('xs'); ?>"></a>
				</div>
				<h3><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h3>
				<div class="post-meta">Posted <?php echo $postInfo->getPostedAgo(); ?> ago</div>
				<div class="reset"></div>
			</div>
			<?php $posts = $postInfo->getOlderVideos($userID, 2);
			if($posts){
				foreach($posts as $key=>$entry){
					$entryInfo = new PostInfo($entry);
					?>
					<div class="item">
						<div class="image">
							<a href="<?php echo $entryInfo->getPostURL($userID, true); ?>"><img src="<?php echo $entryInfo->getVideoThumbURL('xs'); ?>"></a>
						</div>
						<h3><a href="<?php echo $entryInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $entryInfo->getPostTitle(); ?>"><?php echo $entryInfo->getPostTitle(); ?></a></h3>
						<div class="post-meta">Posted <?php echo $entryInfo->getPostedAgo(); ?> ago</div>
						<div class="reset"></div>
					</div>
			<?php }
			} ?>
				</div>
			</div>
		<?php } ?>
</div>
<div class="reset"></div>

<?php require(dirname(__FILE__).'/footer.php'); ?>
