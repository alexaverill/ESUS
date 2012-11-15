<?php
include('header.php');
	if(strlen($_SESSION['admin_name'])>3 && $allow_run==5){
		allowed();
	}else{
		echo '<h1>You Are Not allowed here</h1>';
	}
function allowed(){
	echo '<h1>Control Events and Timers</h1>
	</script>';
	echo '    <div id="tabstrip">';
	if($_POST['add_slot']||$_POST['add']||$_POST['add_slot_select']||$_POST['drop_slot']||$_POST['slotto_event']||$_POST['drop_event_and_time']||$_POST['add_event']||$_POST['drop_event']||$_POST['changetable']){
	             echo'   <ul>
	                    <li>
	                        Timer
	                    </li>
	                    <li >
	                       Slots Beta
	                    </li>
	                    <li class="k-state-active">
	                    	Events
	                    </li>
	                </ul><div>';
					}else{
					echo '   <ul>
	                    <li class="k-state-active">
	                        Timer
	                    </li>
	                    <li>
	                       Slots Beta
	                    </li>
	                    <li>
	                    	Events
	                    </li>
	                </ul>
	                <div>';
					}
	echo '<br/><h3>Start and End Date</h3>';
		if($_POST['start_month']<=0)
		{
			get_timer();
		}

		if($_POST['time'])
		{
			change_timer();
		}	
				echo '<form method="POST" action="">Start Date:<select name="start_month">';
			draw_months(1);
				echo'</select><select name="start_day">';
			draw_days(1);
				echo'</select><select name="start_year">';
			draw_years_start();
				echo'</select>at <select name="start_hour">';
			draw_hours_start();
				 echo'</select>:<select name="start_min">'; 
			draw_minutes(1);
				echo '</select><br/>End Date:  <select name="end_month">';
			draw_months(2);
				echo'</select><select name="end_day">';
			draw_days(2);
				echo'</select><select name="end_year">';
			draw_years_end();
				echo'</select> at <select name="end_hour">';
			draw_hours_end();
			 	echo'</select>:<select name="end_min">';
			draw_minutes();
				echo '</select><br/><input type="submit" class="myButton" name="time" value="Update Timer"/></form><br/>
				<h3>Timer Usage</h3>
				Change how your signup will open<br/>';

		if($_POST['change_status']){
			change_status();
		}
		if($_POST['enable']<=0){
		draw_enable();
		}

	draw_enable_select();
	echo '</div>';
				echo'<div>This is an Experimental Feature, that allows you to quickly add Time Slots.<br/>
				Enter the start hour of your tournement in the 24 hour time format (ex. 08) and the end hour
				in the 24 hour format, so 4pm would be 16. <br/>Lastly add the length of time of each slot. Like 10 minutes, or 15 minutes, or 50 or 60 minutes.
				these are the only suggested time intervals at the moment. Please submit feedback to alex.averill2013@gmail.com

<br/><b> Refresh, and check before you try this again, if you think that it didn\'t work</b>
				<form method="POST" action="">
Start Hour:<input type="text" name="1"/><Br/>
End Hour:<input type="text" name="2"/><Br/>
Length of Slots:<input type="text" name="3"/><Br/>
<!--Length of Break:<input type="text" value="0"/><br/>-->
<input type="submit" name="yay"/>
</form></div><div>';
	echo '<h2>Add Event Times</h2>';

	 
	echo '<form method="POST" action="">
			<b>Event Name:</b><input type="text" name="event_name"/>
					<input type="submit" class="myButton" value="Add Event" name="add"/>
			</form><br/>';

	echo '<form method="POST" action="">
			<b>Time Slot:</b><input type="text" name="time_slot"/>
			<input type="submit" class="myButton" value="Add Time Slot" name="add_slot"/>
			</form><br/>';
	echo '<h3>Edit Events(click to edit)</h3>';
	list_events();
	echo '<h3>Edit Times(click to edit)</h3>';
	list_times();
		if($_POST['add_slot']){
			add_time_slot();
		}
		if($_POST['add_slot_select']){
	    	add_time_select();
		}
		if($_POST['add']){
			addevent();
		}
		if($_POST['drop_slot']){
			drop_slot();
		}
		if($_POST['slotto_event']){
	   		add_table_times();
		}
	draw_table_adding_slots();
	echo '<br/>';
	echo '<h2>Number of Slots</h2>';
	if($_POST['changetable']){
		change_table();					
	}
	echo '<form method="POST" action=""><select name="typein">';
	$qry='SELECT * FROM `settings`';
		$check= mysql_query($qry);
		while ($look=mysql_fetch_array($check)){
			$run=1;
			while ($run<=10){
					if($look['tables']==$run){
						echo '<option value="'.$run.'" selected="selected">'.$run.' slots</option>';
					}else{
						echo '<option value="'.$run.'">'.$run.' slots</option>';
					}
				$run+=1;
			}
		}														
		echo '	</select><input type="submit" value="Change Tables" name="changetable" class="myButton"></form>';

	if($_POST['changetable']){
		change_table();					
	}

		echo '<h3><a id="drop">Drop Events or Slots (click here to view)</a></h3><div id="drop_box">';
		echo '<form method="POST" action="">';
		echo '<form method="POST" action="">'.draw_event_select().'<input type="submit" class="myButton" name="drop_event" value="Drop This Event"/>Caution. Totally removes all event data for this event</form>';
		echo '</form>';
	draw_drop_slot();
		echo'</div>';

	if($_POST['drop_slot']){
		drop_slot();

	}
	if($_POST['drop_event']){
		$event=$_POST['eventname'];
		$times_remove="DELETE FROM `times` WHERE `event`='$event'";
		$event_remove="DELETE FROM `event` WHERE `event`='$event'";
		$event_delete=mysql_query($event_remove) or die(mysql_error());
		$time_delete=mysql_query($times_remove) or die(mysql_error());
		echo 'Event Removed';
	}
			if($_POST['drop_event_and_time']){
				remove_slot_from_event();
			}
		draw_time_removal();
		echo 'Caution: Dropping a time slot will cause all data to dissappear for that hour.';
			if ($_POST['adduser'])
			{ 
			    adduser();
			}
			if($_POST['submitted'])
			{
				addevent();
			 
			}
			if($_POST['drop_event'])
			{
				event_removal();
			}
			if($_POST['change_pass'])
			{
				reset_password();
			}
			if($_POST['add_admin'])
			{
				add_admin();
			}
	}
	echo ' </div>';


if($_POST['yay']){
	boom();
}


function boom(){
	$f=$_POST['1'];
	$s=$_POST['2'];
	$n = $_POST['3'];
//if($_POST['1']<=$_POST['2']){
	bulk_add_new($f,$s,$n);
//}
}
function bulk_add_new($first,$second,$third){
	$distance = $second-$first;
	switch($third){
		case 60:
			add_six($first,$second,$third,$distance);
			break;
		case 50:
			add_six($first,$second,$third,$distance);
			break;
		case 10:
			add_ten($first,$second,$third,$distance);
			break;
		default:
			add_generate($first,$second,$third,$distance);
			break;
	}

}
function add_six($first,$second,$third,$distance){
	echo '<br/>60<br/>';
	$minutes=$distance*60;
	if ($third==60){
		$third-=10;
	}
	$slots= $minutes/$third;
	$ending='00';
	//$final_tm=50;
	while($first<$second){
		$send_sql=$first.':'.$ending.'-'.$first.':50';
		$sql= "INSERT INTO `slots` (`time_slot`) VALUES ('$send_sql');";
		$insert = mysql_query($sql)or die("Could not insert data because ".mysql_error());
		$first+=1;
	}

}
function add_ten($first,$second,$third,$distance){
	$distance= $second-$first;
	//echo 'distance= '.$distance.'<br/>';
	$minutes=$distance*60;
	//echo 'minutes= '.$minutes;
	$slots= $minutes/$third;
	//echo '<br/>slots= '.$slots.'<br/>';
	$ending='00';
	$final_tm=60-$third;
	//echo $final_tm.'<br/>';
	while($x<=$slots){
		if($ending<=40){
			$last=$ending+$third;
			$lasty=$first;
		}else{
			$last='00';
			$lasttest=$first+1;
			if($lasttest<=$second){
				$lasty=$first+1;
			}else{
				$lasty=$first;
			}
		}
		$send_sql= $first.':'.$ending.'-'.$lasty.':'.$last;
		$sql= "INSERT INTO `slots` (`time_slot`) VALUES ('$send_sql');";
		$insert = mysql_query($sql)or die("Could not insert data because ".mysql_error());
		if($ending<=40){

			$ending+=$third;
		
		}else{
			$ending='00';
			$first+=1;
		}

		$x +=1;
	}

}
function add_generate($first,$second,$third,$distance){
	$distance= $second-$first;
	//echo 'distance= '.$distance.'<br/>';
	$minutes=$distance*60;
	//echo 'minutes= '.$minutes;
	$slots= $minutes/$third;
	//echo '<br/>slots= '.$slots.'<br/>';
	$ending='00';
	$final_tm=60-$third;
	//echo $final_tm.'<br/>';
	while($x<=$slots){
		if($ending<=40){
			$last=$ending+$third;
			$lasty=$first;
		}else{
			$last='00';
			$lasttest=$first+1;
			if($lasttest<=$second){
				$lasty=$first+1;
			}else{
				$lasty=$first;
			}
		}
		$send_sql= $first.':'.$ending.'-'.$lasty.':'.$last;
		$sql= "INSERT INTO `slots` (`time_slot`) VALUES ('$send_sql');";
		$insert = mysql_query($sql)or die("Could not insert data because ".mysql_error());
		if($ending<=40){

			$ending+=$third;
		
		}else{
			$ending='00';
			$first+=1;
		}

		$x +=1;
	}

}



	      echo'      <script>
	                $(document).ready(function() {
	                    $("#tabstrip").kendoTabStrip();
	                });
	            </script>';
//echo '<div id="footer"><a href="http://violingeek12.com/esus/">Copyright Alex Averill</a></div>';
include('footer.php');
