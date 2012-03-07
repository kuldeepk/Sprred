<?php
session_start();
/* Include Files *********************/
require_once(dirname(__FILE__)."/../../conf/config.inc.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserLog.dao.php");
/*************************************/

$title = 'Search Results For "'. $_GET['q'] .'" on Sprred';

if(isset($_GET['page']))
	$page = $_GET['page'];
else
	$page= 1;

$LIMIT = 10;
?>

<?php require(dirname(__FILE__).'/../../templates/admin/header.inc.php'); ?>
<div id="contents" class="rounded5">
	<div id="loading" class="rounded2">Loading...</div>
	<div id="main-contents" class="rounded5">

	<form id="search-box" method="get" action="" class="rounded6">
		<input type="text" name="q" size="30" value="<?php echo $_GET['q']; ?>">
		<input type="submit" value="Search" id="s-button">
		<!-- <br><div class="filter"><input type="checkbox" name="profile" value="1" <?php if($activeProfile) { echo 'checked="checked"'; } ?> > Show only people with active profiles</div>  -->
	</form>
	<?php
		if(isset($_GET['q']))
			echo '<h1>Search Results For <b>"'. $_GET['q'] .'"</b></h1>';
	?>
	<div id="users-list">
	<?php
		if(isset($_GET['q']))
			$userList = mysql_query("SELECT ID,fullname FROM user WHERE fullname LIKE '%". filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING) ."%' ORDER BY created DESC LIMIT ". ($page - 1) * $LIMIT .",". $LIMIT); 
		else
			$userList = mysql_query("SELECT ID,fullname FROM user ORDER BY created DESC LIMIT ". ($page - 1) * $LIMIT .",". $LIMIT);
		while($row = mysql_fetch_row($userList)){
			$userInfo = new UserInfoDAO($row[0]);
			$userLog = new UserLogDAO($row[0]);
			$info = $userLog->getLog();
			echo '<div class="list item">';
			//drawUserImageOnly($row[0], 60, true);
			echo '<div class="meta"><h2><a href="'. $userInfo->getProfileURL() .'">'. $userInfo->getFullName() .'</a></h2><p class="desc">';
			echo '<a href="'. $userInfo->getProfileURL() .'">'. $userInfo->getProfileURL() .'</a>';
			echo '<br><label>'. $userInfo->getEmail() .'</label>';
			if($info['countryCode'])
				echo '<br><label>'. $info['country'].', '.$info['countryCode'] .'</label>';
			echo '</p></div><br>';
			echo '<div class="reset"></div></div>';
		}
		if(!mysql_num_rows($userList))
			echo "Sorry, No Entries Found!";
	?>	
	<div class="reset"></div>
	<?php 
		if(isset($_GET['q'])){
			$result = mysql_query("SELECT COUNT(*) FROM user WHERE fullname LIKE '%". filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING) ."%'");
			$row = mysql_fetch_row($result);
			$num = $row[0];	
		} else{
			$result = mysql_query("SELECT COUNT(*) FROM user");
			$row = mysql_fetch_row($result);
			$num = $row[0];	
		}
		$pages = ceil($num / $LIMIT);
	?>
	<p>No of Users: <?php echo $num; ?></p>
		<div id="page-list">
			<?php 
				/*
				if($pages > 1 && ($page - 1)){
					echo '<a href="?page='. ($page-1) .'">&lt;&lt; Prev</a>';
				}
				*/
				if($page > 1){
					if(isset($_GET['q']))
						echo '<a href="?q='. $_GET['q'] .'&page='. ($page-1) .'&profile='. $activeProfile .'">&lt;</a>';
					else
						echo '<a href="?page='. ($page-1) .'&profile='. $activeProfile .'">&lt;</a>';
				}
				if($page >= 8){
					if(isset($_GET['q'])){
						$query = '?q='. $_GET['q'] .'&page=1&profile='. $activeProfile;
						$query2 = '?q='. $_GET['q'] .'&page=2&profile='. $activeProfile;
					}
					else{
						$query = '?page=1&profile='. $activeProfile;
						$query2 = '?page=2&profile='. $activeProfile;
					}
					echo '<a href="'. $query .'">'. 1 . '</a>';
					echo '<a href="'. $query2 .'">'. 2 . '</a>';
					echo ' ... ';
				}
				
				$cnt = 1;
				if($page > 1)
					$cnt = $page - 1;
				$limit=$cnt+7;
				if($page >= ($pages-7)){
					$limit = $pages;
					if($pages > 7)
						$cnt = $pages-8;
				}
				while(($cnt <= $limit) && ($pages > 1)){
					if(isset($_GET['q']))
						$query = '?q='. $_GET['q'] .'&page='. $cnt .'&profile='. $activeProfile;
					else
						$query = '?page='. $cnt .'&profile='. $activeProfile;
					if($cnt == $page)
						echo '<a href="'. $query .'" class="selected">'. $cnt . '</a>';
					else
						echo '<a href="'. $query .'">'. $cnt . '</a>';				
					$cnt++;
				}
				if($page <= ($pages-2) && ($page < ($pages-7))){
					if(isset($_GET['q'])){
						$query = '?q='. $_GET['q'] .'&page='. ($pages - 1) .'&profile='. $activeProfile;
						$query2 = '?q='. $_GET['q'] .'&page='. $pages .'&profile='. $activeProfile;
					}
					else{
						$query = '?page='. ($pages-1) .'&profile='. $activeProfile;
						$query2 = '?page='. $pages .'&profile='. $activeProfile;
					}
					echo ' ... ';
					echo '<a href="'. $query .'">'. ($pages - 1) . '</a>';
					echo '<a href="'. $query2 .'">'. $pages . '</a>';
				}
				if($pages >= $page + 1){
					if(isset($_GET['q']))
						echo '<a href="?q='. $_GET['q'] .'&page='. ($page+1) .'&profile='. $activeProfile .'">&gt;</a>';
					else
						echo '<a href="?page='. ($page+1) .'&profile='. $activeProfile .'">&gt;</a>';
				}
			?>
		</div>
	</div>
	</div>
</div> <!--contents-->
<?php require(dirname(__FILE__).'/../../templates/admin/footer.inc.php'); ?>


