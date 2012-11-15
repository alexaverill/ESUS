<?php include('header.php');
//-------------------------------------------------------Security Stuff: makes sure user is logged in

if(strlen($_SESSION['admin_name'])>=2 && $allow_run ==5){
		$safe=true;
		writeform();

}
if($_SESSION['install']==$install_value){
		if(strlen($_SESSION['name'])<=0 && $allow_run ==5){
			$safe=false;
			echo 'Please login <a href="login.php">Here</a>';
		} 
		else if(strlen($_SESSION['name'])>=2 && $allow_run ==5)
		{
			$enable_value= "SELECT * FROM  `enable` ";
			$enabled = mysql_query($enable_value)or die("Could not insert data because ".mysql_error());
			while($run= mysql_fetch_assoc($enabled)) {
				switch($run['enabled']){
						case 1:
							$safe=true;
							write_form();
							break;
						case 2:
							$safe=false;
							echo 'It is currently disabled. Please check back later';
							break;
						default:
							$safe=false;
							echo 'It is currently disabled. Please check back later';
							break;
				}
				if($time_left>=5)
				{
					$safe=true;
					writeform();
				}else if($time_left<=0)
				{
					echo 'It is not time. Please check back later';
				}

				/*if ($run['enabled']==1){
					$safe=true;
					writeform();
				}else if ($run['enabled']==2){
					$safe=false;
					echo 'It is currently disabled. Please check back later';
				}else if ($time_left>=5){
				$safe=true;
				writeform();
				}else if($time_left<=0){
					echo 'It is not time. Please check back later';
					}*/
			}
		}
	}else{
		echo 'You are not allowed here<br/>';
		echo 'Please login <a href="login.php">Here</a>';
	}
function writeform(){
	echo'<h1>Select Event Times</h1>'; 
		if(!$_POST['event'])
		{
			draw_all_events();
		}

		}  		
		if ($_POST['submitted'])
		{ 
		  if ($safe==true)
		  {
		    getEvent($_POST['time']);	
		  }
		}
		/*if ($_POST['search_event'])
		{
			if($safe==true){
				searchEvent($_POST['eventname']);
			}

		}
*/
		if($_POST['getthis']){
			addTime();
		}
	function addTime(){			/*This sets up where the time needs to be added as well as adds the time to database in some instances*/
			$br = '<br/>';
			$event= $_POST['event'];
			$name=mysql_real_escape_string($_SESSION['name']);
			$sql = "SELECT * FROM `times` WHERE `event` ='$even' ORDER BY `times`.`time_id` ASC";
			$sqlnum1= mysql_query($sql) or die(mysql_error());
			$getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die (mysql_error()); //Gets user ID query
			$tblcl = "</td>";
		while($getname= mysql_fetch_array($getid)){		//Picks out user ID
			$id= $getname['id'];		
		}
		$slot = $_POST['slot'];
		$slot = mysql_real_escape_string($slot);
		$hour = $_POST['time'];
		$hour = mysql_real_escape_string($hour);
		$team='team'.$slot;
		$sqlnum1= mysql_query("SELECT * FROM  `times` WHERE `event` ='$event'") or die(mysql_error()); //Gets the Event row from database
	while($row = mysql_fetch_array($sqlnum1)) {
	$clear=TRUE;							/*Need to figure out why my while loop wasnt working and implement one*/
		if($row['team1']==  0){				/* 11/6/12 This is still ugly, but it works, and I dont want to break it....*/
			if($row['time_id']==$hour){
				add_to_database(1);
				$ready=5;
			}else{
				add_to_database(1);
				$ready=5;
			}
		}else if($row['team2'] == 0){
			if($row['time_id']==$hour){
				add_to_database(2);
				$ready=5;
			}else{
				
				add_to_database(2);
				$ready=5;
			}
		}else if($row['team3'] == 0){
			if($row['time_id']==$hour){
				add_to_database(3);
				$ready=5;
			}else{
				
				add_to_database(3);
				$ready=5;
			}
		}else if($row['team4'] == 0){
			if($row['time_id']==$hour){
				add_to_database(4);
				$ready=5;
			}else{
				add_to_database(4);
				$ready=5;
			}
		}else if($row['team5'] == 0){
			if($row['time_id']==$hour){
				add_to_database(5);
				$ready=5;
			}else{
				add_to_database(5);
				$ready=5;
			}
		}else if($row['team6'] == 0){
			if($row['time_id']==$hour){
				add_to_database(6);
				$ready=5;
			}else{
				add_to_database(6);
				$ready=5;
			}
		}else if($row['team7'] == 0){
			if($row['time_id']==$hour){
				add_to_database(7);
				$ready=5;
			}else{
				add_to_database(7);
				$ready=5;
			}
		}else if($row['team8'] == 0){
			if($row['time_id']==$hour){
				add_to_database(8);
				$ready=5;
			}else{
				add_to_database(8);
				$ready=5;
			}
		}else if($row['team9'] == 0){
			if($row['time_id']==$hour){
				add_to_database(9);
				$ready=5;
			}else{
				add_to_database(9);
				$ready=5;
			}
		}else if($row['team10'] == 0){
			if($row['time_id']==$hour){
				add_to_database(10);
				$ready=5;
			}else{
				add_to_database(10);
				$ready=5;
			}
		}else{
			
		}
	}				/*Having some wierd issues here where half the time it goes to this area and the other half it goes where I want it to(add_to_database())*/
	}
function add_to_database($where){  //Addes user to time table in database	
	$br = '<br/>';
	$event= $_POST['event'];
	//$id = $_POST['id'];
			$name=mysql_real_escape_string($_SESSION['name']);
			$sql = "SELECT * FROM `times` WHERE `event` ='$even' ORDER BY `times`.`time_id` ASC";
			$sqlnum1= mysql_query($sql) or die(mysql_error());
			$getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die (mysql_error()); //Gets ID again.. May want to make this a global function....
			$tblcl = "</td>";
		while($getname= mysql_fetch_array($getid)){
			$id= $getname['id'];
		}
	$slot = $_POST['slot'];
	$hour = $_POST['time'];
	//echo $hour;
	$teamnum = 'team'.$where;
	//echo 'TeamNum:'.$teamnum.'<br/>';

	$team='team'.$slot;
	$slote=1;
	$query="SELECT * FROM  `times` WHERE `event` ='$event'";//AND `$teamnum` = '$id'";
	//echo $query;
	$sqlnum= mysql_query($query) or die(mysql_error());
	while($row1= mysql_fetch_array($sqlnum)){

	$row=$row1['time_id'];
	//echo $row;
	$run=1;
	 while($run<=10){
	 	$teaming='team'.$run;
		if($row1['team'.$run]==$id){
			if($row['time_id']!=$hour){
				$sql= "UPDATE `times` SET `$teaming` =  '0' WHERE `time_id` ='$row' AND  `times`.`event` =  '$event'";
				//echo $sql;
				$clean = mysql_query($sql)or die(mysql_error());
			}
		}
		$run++;
	}
	}
	$allow_change=1;
	if($allow_change==1){	
	//Check to make sure it is actually the first open time;
	$query="SELECT * FROM  `times` WHERE `event` ='$event' AND `time_id` = '$hour'";//AND `$teamnum` = '$id'";
	//echo $query;
	$sqlnum= mysql_query($query) or die(mysql_error());
	while($row1= mysql_fetch_array($sqlnum)){

	$row=$row1['time_id'];
	$run=1;
	 while($run<=10){
	 	$teaming='team'.$run;
		if($row1['team'.$run]==0){
			$sqq = "UPDATE `times` SET `$teaming`='$id' WHERE `time_id` = '$hour' AND `event` = '$event' LIMIT 1";
			if(strlen($_SESSION['admin_name'])==0){
			$update=mysql_query($sqq)or die("Could not insert data because ".mysql_error());
			}else{
				echo '<div class="red">Sorry admin you can not do that</div>'; //Stops over eager admin
			}
			break;
		}
		$run++;
	}
	}	
	$check = "SELECT `$team` FROM `times`	WHERE `time_id` = '$hour' AND `event` = '$event'";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row4= mysql_fetch_assoc($checker)) {
		if ($row4[''.$team.''] == $id){
		$cheky= $team;
		}else{
			$cheky=0;
			}

	}
	if ($team==$cheky){ //Makes sure the user got the slot
	//Echo $br.'You now have '. $event. ' at '.$hour;
	//searchEvent($event);
	//echo '<META HTTP-EQUIV=Refresh CONTENT=".01; URL=index.php">';
	}
	}else{
	echo '<div class="red">Another team has selected that slot since you have refreshed. Please choose another slot.</div>';
	}
	}
	if($_POST['event']){
		draw_all_events();
	}
include('footer.php');

?>
