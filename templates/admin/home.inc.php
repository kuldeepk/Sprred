<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/ViewPosts.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php"); 
/*************************************/

$view = new ViewPostDAO();

?>

<div id="home">
	<?php 
		$result = mysql_query("SELECT COUNT(*) FROM user");
		$row = mysql_fetch_row($result);
		$num = $row[0];
		$result2 = mysql_query("SELECT COUNT(*) FROM user where confirmed=1");
		$row2 = mysql_fetch_row($result2);
		$num2 = $row2[0];
		$result3 = mysql_query("SELECT COUNT(*) FROM user where fullname='Unknown'");
		$row3 = mysql_fetch_row($result3);
		$num3 = $row3[0];
		$result4 = mysql_query("SELECT COUNT(*) FROM profile_info where name='Untitled'");
		$row4 = mysql_fetch_row($result4);
		$num4 = $row4[0];
	?>
	<p>Total No. of Users: <b><?php echo $num; ?></b></p>
	<p>No. of Confirmed Accounts: <b><?php echo $num2; ?></b></p>
	<p>No. of 'Unknown' Users: <b><?php echo $num3; ?></b></p>
	<p>No. of 'Untitled' Sprred: <b><?php echo $num4; ?></b></p>
	<hr>
	<p>Total No. of Posts: <b><?php echo $view->getPostsCount(); ?></b></p>
	<p>No. of Blog Posts: <b><?php echo $view->getPostsCount(null, array('blog')); ?></b></p>
	<p>No. of Photos: <b><?php echo $view->getPostsCount(null, array('photo')); ?></b></p>
	<p>No. of Videos: <b><?php echo $view->getPostsCount(null, array('video')); ?></b></p>
	<p>No. of Links: <b><?php echo $view->getPostsCount(null, array('link')); ?></b></p>
	<hr>
	<p>No. of Total Private Posts: <b><?php echo $view->getPostsCount(null, null, array('private')); ?></b></p>
	<div class="reset"></div>
</div>