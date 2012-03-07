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

<form class="update-form" id="personal-info">
	<h1>Edit Your Personal Profile</h1>
	<h2>Basic Info</h2>
	<div class="row">
		<label>Gender</label>
		<small class="input-group">
			<input type="radio" name="sex" value="male" class="radio" <?php if($info->getSex() == "male"){ ?> checked="checked" <?php } ?>> Male 
			<input type="radio" name="sex" value="female" class="radio" <?php if($info->getSex() == "female"){ ?> checked="checked" <?php } ?>> Female 
			<input type="radio" name="sex" value="unspecified" class="radio" <?php if($info->getSex() != "male" && $info->getSex() != "female"){ ?> checked="checked" <?php } ?>> Unspecified
		</small>
		<div class="reset"></div>
	</div>
	<div class="row">
		<label>Birthday</label>
		<small class="input-group">
			<select name="birth-month" class="drop-down">
				<?php $birthMonth = $info->getBirthMonth();	?>
				<option value="">Month: </option>
				<option value="Jan" <?php if($birthMonth == "Jan"){ ?> selected="selected" <?php } ?>>Jan</option>
				<option value="Feb" <?php if($birthMonth == "Feb"){ ?> selected="selected" <?php } ?>>Feb</option>
				<option value="Mar" <?php if($birthMonth == "Mar"){ ?> selected="selected" <?php } ?>>Mar</option>
				<option value="Apr" <?php if($birthMonth == "Apr"){ ?> selected="selected" <?php } ?>>Apr</option>
				<option value="May" <?php if($birthMonth == "May"){ ?> selected="selected" <?php } ?>>May</option>
				<option value="Jun" <?php if($birthMonth == "Jun"){ ?> selected="selected" <?php } ?>>Jun</option>
				<option value="Jul" <?php if($birthMonth == "Jul"){ ?> selected="selected" <?php } ?>>Jul</option>
				<option value="Aug" <?php if($birthMonth == "Aug"){ ?> selected="selected" <?php } ?>>Aug</option>
				<option value="Sep" <?php if($birthMonth == "Sep"){ ?> selected="selected" <?php } ?>>Sep</option>
				<option value="Oct" <?php if($birthMonth == "Oct"){ ?> selected="selected" <?php } ?>>Oct</option>
				<option value="Nov" <?php if($birthMonth == "Nov"){ ?> selected="selected" <?php } ?>>Nov</option>
				<option value="Dec" <?php if($birthMonth == "Dec"){ ?> selected="selected" <?php } ?>>Dec</option>
			</select>
			<select name="birth-date" class="drop-down">
				<option value="">Date: </option>
				<?php $birthDate = $info->getBirthDate();
				for($cnt=1;$cnt<32;$cnt++){ ?>
					<option value="<?php echo $cnt; ?>" <?php if($birthDate == $cnt){ ?>  selected="selected" <?php } ?>><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
			<select name="birth-year" class="drop-down">
				<option value="">Year: </option>
				<?php $birthYear = $info->getBirthYear(); 
				for($cnt=(int)date("Y");$cnt>=1900;$cnt--){ ?>
					<option value="<?php echo $cnt; ?>" <?php if($birthYear == $cnt){ ?>  selected="selected" <?php } ?>><?php echo $cnt; ?></option>
				<?php } ?>
			</select>
		</small>
		<div class="reset"></div>
	</div>
	<p class="row"><label>Hometown</label><input type="text" name="hometown" class="text" value="<?php echo $info->getHometown();?>"></p>
	<p class="row"><label>About Me</label><textarea name="aboutme" class="text"><?php echo $info->getAboutMe();?></textarea></p>
	<?php flush(); ?>
	<h2>Interests</h2>
	<p class="row"><label>Activities / Hobbies</label><textarea name="hobbies" class="text"><?php echo $info->getHobbies();?></textarea></p>
	<p class="row"><label>Favorite Music</label><textarea name="music" class="text"><?php echo $info->getFavMusic();?></textarea></p>
	<p class="row"><label>Favorite Movies</label><textarea name="movies" class="text"><?php echo $info->getFavMovies();?></textarea></p>
	<p class="row"><label>Favorite Books</label><textarea name="books" class="text"><?php echo $info->getFavBooks();?></textarea></p>
	<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-persnl-info', $('form#personal-info').serialize());"></p>
</form>