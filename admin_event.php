<?php include('header.php');
	if(strlen($_SESSION['admin_name'])>3 && $allow_run==5){

		echo'<h1>View Event Sign Ups</h1><h3>View Events</h3><form method="POST" action=""> Event';
			draw_event_select();
		echo '<input class="myButton" type="submit" value="Show this Event" name="search_event"/></form><br/>';
		echo '<h3><a href="printable.php">View all events in a printable form</a>, or select and event and you can print that event from this page. Just press Control + P</h3>';
	}else{
		echo '<h1>You Are Not allowed here</h1>';
	}

?>
<?php
	if($_POST['dump']){
		echo '<a href="newer_excel.php">Download all the events</a>';
		
	}

	if ($_POST['search_event']){
			admin_draw_event_table($_POST['eventname']);

	}

	if($_POST['getthis']){
		addTime_admin();
	}
	if($_POST['closethis']){
		close_slot();

	}
include('footer.php');
?>
