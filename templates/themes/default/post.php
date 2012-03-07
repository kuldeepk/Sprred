<?php 

$postInfo = new PostInfo($post);

?>

<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="content_wrap" class="rounded5">
<div id="content">
	<div id="blog-content">
	<?php if($postInfo){ ?>
		<div class="post">
			<h2><a href="<?php echo $postInfo->getPostURL($userID, true); ?>" title="Permanent Link to <?php echo $postInfo->getPostTitle(); ?>"><?php echo $postInfo->getPostTitle(); ?></a></h2>
			<div class="entry">
				<?php echo $postInfo->getBlogContent(); ?>
			</div>
			<div class="post_details">
				Posted <?php echo $postInfo->getPostedAgo(); ?> ago<br>
			</div>
			<div class="share-links blog-share">
				<div class="tw-share"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="Sprred">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
				<div class="fb-share"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($postInfo->getPostURL($userID, false)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe></div>
				<div class="reset"></div>
			</div>
		</div>
	<?php 	
	} else { ?>
		<div class="message">Post not found!</div>
	<?php } ?>
		<div class="reset"></div>
	</div>
</div>

<?php require(dirname(__FILE__).'/sidebar.php'); ?>
<div class="reset"></div>
</div>

<?php require(dirname(__FILE__).'/footer.php'); ?>
