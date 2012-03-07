<?php
session_start();
/* Include Files *********************/
require_once(dirname(__FILE__)."/../../conf/config.inc.php");
require_once(dirname(__FILE__)."/../../includes/dao/ViewPost.dao.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php");
/*************************************/

$title = 'Sprred Admin - Home';

$view = new ViewPostDAO();
?>

<?php require(dirname(__FILE__).'/../../templates/admin/header.inc.php'); ?>
<div id="contents" class="rounded5">
	<div id="loading" class="rounded2">Loading...</div>
	<ul id="main-nav" class="rounded3">
		<li>
			<label><a href="#home" class="inline-nav rounded3">Home</a></label>
			<div class="reset"></div>
		</li>
		<li>
			<label><a href="#allposts" class="inline-nav rounded3">All Posts</a></label>
			<div class="reset"></div>
		</li>
		<div class="reset"></div>
	</ul>
	<div id="main-contents" class="rounded5">
		
	</div>
</div> <!--contents-->
<?php require(dirname(__FILE__).'/../../templates/admin/footer.inc.php'); ?>


