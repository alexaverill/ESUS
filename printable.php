<?php
include('header.php');
	if(strlen($_SESSION['admin_name'])>3 && $allow_run==5)
	{
		allowed();
	}else
	{
		echo '<h1>You Are Not allowed here</h1>';
	}

function allowed(){
	echo '<div class="disclaimer">This page allows you to print off all of your event schedules. 
	All that will print is the tables so no issues with wasted ink.</div>';
	admin_draw_event_table_total();
}
?>