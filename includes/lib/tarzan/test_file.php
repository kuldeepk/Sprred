<?php

//$today2 = date('d M Y H:i:s',time())
disp();

function disp($time)
{
	if(!$time)echo "<li>this is null";
	else echo $time;

}



?>