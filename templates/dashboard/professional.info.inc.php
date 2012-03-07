<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/PersonalInfo.dao.php"); 
require_once(dirname(__FILE__)."/../../includes/dao/ProfessionalInfo.dao.php");
/*************************************/

$info = new PersonalInfoDAO(Auth::getLoggedInID());
$proInfo = new ProfessionalInfoDAO(Auth::getLoggedInID());
?>

<form class="update-form" id="professional-info">
	<h1>Edit Your Professional Profile</h1>
	<?php 
		$eduCount = $proInfo->getEduCount();
		if(!$eduCount)
			$eduCount=1;
		$workCount = $proInfo->getWorkCount();
		if(!$workCount)
			$workCount=1;
	?>
	<input type="hidden" name="edu-count" id="edu-count" value="<?php echo $eduCount;?>">
	<input type="hidden" name="work-count" id="work-count" value="<?php echo $workCount;?>">
	<h2>Educational Info</h2>
	<?php for($count=1;$count<=$eduCount;$count++){ ?>
	<div class="edu-input-grp" id="edu-input-grp-<?php echo $count; ?>">
		<?php if($count>1) { ?><hr><?php } ?>
		<p class="row"><label>College/University</label><input type="text" name="univ-<?php echo $count; ?>" class="text" value="<?php echo $proInfo->getUniv($count);?>"></p>
		<div class="row">
			<label>Year of Pass-out</label>
			<select name="univ-year-<?php echo $count; ?>" class="drop-down">
				<option value="">Year: </option>
				<?php $univYear = $proInfo->getUnivYear($count);
				for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
				<option value="<?php echo $cnt; ?>" <?php if($univYear == $cnt){ ?>  selected="selected" <?php } ?>><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<div class="reset"></div>
		</div>
		<p class="row"><label>Degree</label><input type="text" name="degree-<?php echo $count; ?>" class="text" value="<?php echo $proInfo->getUnivDegree($count);?>"></p>
		<p class="row"><label>Concentration</label><input type="text" name="concentration-<?php echo $count; ?>" class="text" value="<?php echo $proInfo->getUnivFocus($count);?>"></p>
	</div>
	<?php flush(); ?>
	<?php } ?>
	<a href="Javascript:void(0);" onclick="copyEduGroup(this);">Add one more entry</a>
	<div id="edu-input-dumy-grp" class="edu-input-grp" style="display:none;">
		<hr>
		<p class="row"><label>College/University</label><input type="text" name="univ-" class="text"></p>
		<div class="row">
			<label>Year of Pass-out</label>
			<select name="univ-year-" class="drop-down">
				<option value="">Year: </option>
				<?php for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
				<option value="<?php echo $cnt; ?>"><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<div class="reset"></div>
		</div>
		<p class="row"><label>Degree</label><input type="text" name="degree-" class="text"></p>
		<p class="row"><label>Concentration</label><input type="text" name="concentration-" class="text"></p>
	</div>
	<h2>Work Info</h2>
	<?php for($count=1;$count<=$workCount;$count++){ ?>
	<div class="work-input-grp">
		<?php if($count>1) { ?><hr><?php } ?>
		<p class="row"><label>Employer Name</label><input type="text" name="employer-<?php echo $count; ?>" class="text" value="<?php echo $proInfo->getEmployer($count);?>"></p>
		<p class="row"><label>Title</label><input type="text" name="work-title-<?php echo $count; ?>" class="text" value="<?php echo $proInfo->getWorkTitle($count);?>"></p>
		<p class="row"><label>Description</label><textarea name="work-desc-<?php echo $count; ?>" class="text" value="<?php echo $proInfo->getWorkDesc($count);?>"></textarea></p>
		<div class="row">
			<label>Working From</label>
			<select name="work-from-month-<?php echo $count; ?>" class="drop-down">
				<?php $workFromMonth = $proInfo->getWorkFromMonth();	?>
				<option value="">Month: </option>
				<option value="Jan" <?php if($workFromMonth == "Jan"){ ?> selected="selected" <?php } ?>>Jan</option>
				<option value="Feb" <?php if($workFromMonth == "Feb"){ ?> selected="selected" <?php } ?>>Feb</option>
				<option value="Mar" <?php if($workFromMonth == "Mar"){ ?> selected="selected" <?php } ?>>Mar</option>
				<option value="Apr" <?php if($workFromMonth == "Apr"){ ?> selected="selected" <?php } ?>>Apr</option>
				<option value="May" <?php if($workFromMonth == "May"){ ?> selected="selected" <?php } ?>>May</option>
				<option value="Jun" <?php if($workFromMonth == "Jun"){ ?> selected="selected" <?php } ?>>Jun</option>
				<option value="Jul" <?php if($workFromMonth == "Jul"){ ?> selected="selected" <?php } ?>>Jul</option>
				<option value="Aug" <?php if($workFromMonth == "Aug"){ ?> selected="selected" <?php } ?>>Aug</option>
				<option value="Sep" <?php if($workFromMonth == "Sep"){ ?> selected="selected" <?php } ?>>Sep</option>
				<option value="Oct" <?php if($workFromMonth == "Oct"){ ?> selected="selected" <?php } ?>>Oct</option>
				<option value="Nov" <?php if($workFromMonth == "Nov"){ ?> selected="selected" <?php } ?>>Nov</option>
				<option value="Dec" <?php if($workFromMonth == "Dec"){ ?> selected="selected" <?php } ?>>Dec</option>
			</select>
			<select name="work-from-year-<?php echo $count; ?>" class="drop-down">
				<option value="">Year: </option>
				<?php $workFromYear = $proInfo->getWorkFromYear($count);
				for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
				<option value="<?php echo $cnt; ?>" <?php if($workFromYear == $cnt){ ?>  selected="selected" <?php } ?>><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<small>To</small>
			<select name="work-till-month-<?php echo $count; ?>" class="drop-down till" <?php if($proInfo->isWorkTillPresent($count) == 'present'){ ?> disabled="true" <?php } ?>>
				<?php $workTillMonth = $proInfo->getWorkTillMonth();	?>
				<option value="">Month: </option>
				<option value="Jan" <?php if($workTillMonth == "Jan"){ ?> selected="selected" <?php } ?>>Jan</option>
				<option value="Feb" <?php if($workTillMonth == "Feb"){ ?> selected="selected" <?php } ?>>Feb</option>
				<option value="Mar" <?php if($workTillMonth == "Mar"){ ?> selected="selected" <?php } ?>>Mar</option>
				<option value="Apr" <?php if($workTillMonth == "Apr"){ ?> selected="selected" <?php } ?>>Apr</option>
				<option value="May" <?php if($workTillMonth == "May"){ ?> selected="selected" <?php } ?>>May</option>
				<option value="Jun" <?php if($workTillMonth == "Jun"){ ?> selected="selected" <?php } ?>>Jun</option>
				<option value="Jul" <?php if($workTillMonth == "Jul"){ ?> selected="selected" <?php } ?>>Jul</option>
				<option value="Aug" <?php if($workTillMonth == "Aug"){ ?> selected="selected" <?php } ?>>Aug</option>
				<option value="Sep" <?php if($workTillMonth == "Sep"){ ?> selected="selected" <?php } ?>>Sep</option>
				<option value="Oct" <?php if($workTillMonth == "Oct"){ ?> selected="selected" <?php } ?>>Oct</option>
				<option value="Nov" <?php if($workTillMonth == "Nov"){ ?> selected="selected" <?php } ?>>Nov</option>
				<option value="Dec" <?php if($workTillMonth == "Dec"){ ?> selected="selected" <?php } ?>>Dec</option>
				</select>
			<select name="work-till-year-<?php echo $count; ?>" class="drop-down till" <?php if($proInfo->isWorkTillPresent($count) == 'present'){ ?> disabled="true" <?php } ?>>
				<option value="">Year: </option>
				<?php $workTillYear = $proInfo->getWorkTillYear($count);
				for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
				<option value="<?php echo $cnt; ?>" <?php if($workTillYear == $cnt){ ?>  selected="selected" <?php } ?>><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<input type="checkbox" name="work-till-present-<?php echo $count; ?>" value="present" onclick="if($(this).is(':checked')){$(this).parent().find('.till').attr('disabled','true');}else{$(this).parent().find('.till').removeAttr('disabled');}" <?php if($proInfo->isWorkTillPresent($count) == 'present'){ ?> checked="checked" <?php } ?>><small>Present</small>
			<div class="reset"></div>
		</div>
	</div>
	<?php flush(); ?>
	<?php } ?>
	<a href="Javascript:void(0);" onclick="copyWorkGroup(this);">Add one more entry</a>
	<div id="work-input-dumy-grp" class="work-input-grp" style="display:none;">
		<hr>
		<p class="row"><label>Employer Name</label><input type="text" name="employer-" class="text"></p>
		<p class="row"><label>Title</label><input type="text" name="work-title-" class="text"></p>
		<p class="row"><label>Description</label><textarea name="work-desc-" class="text"></textarea></p>
		<div class="row">
			<label>Working From</label>
			<select name="work-from-month-" class="drop-down">
				<option value="">Month: </option>
				<option value="Jan">Jan</option>
				<option value="Feb">Feb</option>
				<option value="Mar">Mar</option>
				<option value="Apr">Apr</option>
				<option value="May">May</option>
				<option value="Jun">Jun</option>
				<option value="Jul">Jul</option>
				<option value="Aug">Aug</option>
				<option value="Sep">Sep</option>
				<option value="Oct">Oct</option>
				<option value="Nov">Nov</option>
				<option value="Dec">Dec</option>
			</select>
			<select name="work-from-year-" class="drop-down">
				<option value="">Year: </option>
				<?php for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
				<option value="<?php echo $cnt; ?>"><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<small>To</small>
			<select name="work-till-month-" class="drop-down till">
					<option value="">Month: </option>
					<option value="Jan">Jan</option>
					<option value="Feb">Feb</option>
					<option value="Mar">Mar</option>
					<option value="Apr">Apr</option>
					<option value="May">May</option>
					<option value="Jun">Jun</option>
					<option value="Jul">Jul</option>
					<option value="Aug">Aug</option>
					<option value="Sep">Sep</option>
					<option value="Oct">Oct</option>
					<option value="Nov">Nov</option>
					<option value="Dec">Dec</option>
				</select>
			<select name="work-till-year-" class="drop-down till">
				<option value="">Year: </option>
				<?php for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
				<option value="<?php echo $cnt; ?>"><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<input type="checkbox" name="work-till-present-" value="present" onclick="if($(this).is(':checked')){$(this).parent().find('.till').attr('disabled','true');}else{$(this).parent().find('.till').removeAttr('disabled');}"><small>Present</small>
			<div class="reset"></div>
		</div>
	</div>
	<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-pro-info', $('form#professional-info').serialize());"></p>
	<script>
		function copyEduGroup(elem){
			var count = $('#edu-count').val();
			$('#edu-count').val(++count);
			var temp=document.createElement('div');
			$(temp).html($('#edu-input-dumy-grp').html());
			temp.id = "edu-input-grp-"+count;
			$(temp).find(':input').each(function(){				
				$(this).attr('name', $(this).attr('name')+count);
			});
			$(elem).prev().append($(temp).html());
		}
		function copyWorkGroup(elem){
			var count = $('#work-count').val();
			$('#work-count').val(++count);
			var temp=document.createElement('div');
			$(temp).html($('#work-input-dumy-grp').html());
			temp.id = "work-input-grp-"+count;
			$(temp).find(':input').each(function(){				
				$(this).attr('name', $(this).attr('name')+count);
			});
			$(elem).prev().append($(temp).html());
		}
	</script>
</form>
