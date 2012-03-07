<div id="sidebar">
	<div id="profile-peek" class="element">
		<div id="profile-meta">
			<h1><?php echo $info->getFullName(); ?></h1>
			<?php if($personalInfo->getHometown()) {?><label><b>Location:</b> <?php echo $personalInfo->getHometown(); ?></label><?php } ?>
		</div>
		<div class="reset"></div>
	</div>
	<?php if($personalInfo->getAboutMe()) { ?>
	<div class="element">
		<h2>About Me</h2>
		<p>
			<?php echo $personalInfo->getAboutMe(); ?>
		<br><br><a href="/info">Learn More</a>
		</p>
	</div>
	<?php } ?>
	<a class="rss-link" href="/rss">RSS</a>
	<!-- <h2>Followers <label>(0)</label></h2>
	<div id="followers" class="follow">
		No Followers, yet.
	</div>
	<h2>Following <label>(0)</label></h2>
	<div id="following" class="follow">
		Not Following, yet.
	</div>  -->
</div>