<?php require(dirname(__FILE__).'/header.php'); ?>

<div id="content_wrap" class="rounded5">
<div id="content">
	<div id="info-content">
	<h1><?php echo $info->getFullName(); ?></h1>
	<p>
		<?php if($personalInfo->getAboutMe()) { ?><b>About: </b><?php echo $personalInfo->getAboutMe(); } ?>
		<?php if($personalInfo->getHometown()) { ?><br><br><b>Location: </b><?php echo $personalInfo->getHometown(); } ?>
	</p>
	<ul id="info-sub-header">
		<li class="selected"><a href="Javascript:void(0);" onclick="$('.info-content').hide();$('li.selected').removeClass('selected');$('#personal-info').show();$(this).parent().addClass('selected');">Personal Profile</a></li>
		<li><a href="Javascript:void(0);" onclick="$('.info-content').hide();$('li.selected').removeClass('selected');$('#work-info').show();$(this).parent().addClass('selected');">Professional Profile</a></li>
		<div class="reset"></div>
	</ul>
	<div id="personal-info" class="info-content">
		<h3>Basic Info</h3>
		<?php if($personalInfo->getSex()) { $basic_flag=true; ?><div class="rw"><label>Gender:</label><span><?php echo $personalInfo->getSex(); ?></span></div><?php } ?>
		<?php if($personalInfo->getBirthMonth()) { $basic_flag=true; ?><div class="rw"><label>Birthday:</label><span><?php echo $personalInfo->getBirthDate().' '.$personalInfo->getBirthMonth().' '.$personalInfo->getBirthYear(); ?></span></div><?php } ?>
		<?php if($personalInfo->getHometown()) { $basic_flag=true; ?><div class="rw"><label>Hometown:</label><span><?php echo $personalInfo->getHometown(); ?></span></div><?php } ?>
		<?php if(!$basic_flag){ ?>
				<div>Info not available.</div>
		<?php }	?>
		<h3>Personal Info</h3>
		<?php if($personalInfo->getHobbies()) { $personal_flag=true; ?><div class="rw"><label>Interests:</label><span><?php echo $personalInfo->getHobbies(); ?></span></div><?php } ?>
		<?php if($personalInfo->getFavMusic()) { $personal_flag=true; ?><div class="rw"><label>Favorite Music:</label><span><?php echo $personalInfo->getFavMusic(); ?></span></div><?php } ?>
		<?php if($personalInfo->getFavMovies()) { $personal_flag=true; ?><div class="rw"><label>Favorite Movies:</label><span><?php echo $personalInfo->getFavMovies(); ?></span></div><?php } ?>
		<?php if($personalInfo->getFavBooks()) { $personal_flag=true; ?><div class="rw"><label>Favorite Books:</label><span><?php echo $personalInfo->getFavBooks(); ?></span></div><?php } ?>
		<?php if(!$personal_flag){ ?>
				<div>Info not available.</div>
		<?php }	?>	
	</div>              
	
	<div id="work-info" class="info-content" style="display:none">
		<h3>Work Info</h3>
		<?php 
			$limit = $professionalInfo->getWorkCount();
			for($cnt=1;$cnt<=$limit;$cnt++){ ?>
				<div class="rw"><label>Company:</label><span><?php echo $professionalInfo->getEmployer($cnt); ?></span></div>
				<div class="rw"><label>Position:</label><span><?php echo $professionalInfo->getWorkTitle($cnt); ?></span></div>
				<div class="rw"><label>Duration:</label><span><?php echo $professionalInfo->getWorkFromMonth($cnt).' '.$professionalInfo->getWorkFromYear($cnt); ?> - <?php if($professionalInfo->isWorkTillPresent($cnt))echo "Present"; else echo $professionalInfo->getWorkTillMonth($cnt).' '.$professionalInfo->getWorkTillYear($cnt); ?></span></div>
				<hr>
		<?php }	
			if($cnt == 1){ ?>
				<div>Info not available.</div>
		<?php }	?>
		<h3>Educational Info</h3>
		<?php 
			$limit = $professionalInfo->getEduCount();
			for($cnt=1;$cnt<=$limit;$cnt++){ ?>
				<div class="rw"><label>University:</label><span><?php echo $professionalInfo->getUniv($cnt); ?></span></div>
				<div class="rw"><label>Major:</label><span><?php echo $professionalInfo->getUnivFocus($cnt); ?></span></div>
				<div class="rw"><label>Degree:</label><span><?php echo $professionalInfo->getUnivDegree($cnt); ?></span></div>
				<div class="rw"><label>Year:</label><span><?php echo $professionalInfo->getUnivYear($cnt); ?></span></div>
				<hr>
		<?php }	
			if($cnt == 1){ ?>
				<div>Info not available.</div>
		<?php }	?>
	</div> 
</div>
</div>

<?php require(dirname(__FILE__).'/sidebar.php'); ?>
<div class="reset"></div>
</div>

<?php require(dirname(__FILE__).'/footer.php'); ?>
