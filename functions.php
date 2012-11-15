<?php
$hash="0";
//------------------------------------Admin Area Functions---------------------------
function upload(){						//Upload function for admin area excel files
$target_path = "uploads/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    //Moved file, no response due to trying to keep admin area simple
} else{
    echo "There was an error uploading the file, please try again!";
}
insert($target_path);

}
function draw_teams_select(){
$sql = "SELECT * FROM `team` ORDER BY `name` ASC";
$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
echo '<form action="" method="POST">Team:<select name="team">';
while($row= mysql_fetch_assoc($checker)) {
	echo '<option value="'.$row['username'].'">'.$row['name'].'</option>';
}
echo '</select><br/>
<input name="view_teams" type="submit" class="myButton" value="Send Times"/>


</form>';
}
function display_mail(){
	$name=mysql_real_escape_string($_POST['team']);
	$get_id="SELECT * FROM `team` WHERE `username`='$name'";
	//echo $get_id;
	$get_id=mysql_query($get_id);
	while($row=mysql_fetch_assoc($get_id)){
		$id=$row['id'];
		//echo $id;
		$email=$row['email'];
		//echo $email;
		send_mail($id,$email);
	}
}
function insert($location){			//Addes uploaded Excel file data to database
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$data->read($location);
 	for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
	    $name = $data->sheets[0]["cells"][$x][1];
	    $username = $data->sheets[0]["cells"][$x][2];
	    $password = $data->sheets[0]["cells"][$x][3];
	    $email = $data ->sheets[0]["cells"][$x][4];
		$username=mysql_real_escape_string($username);
		//$password= md5($password); 
		$password = crypt($password);
			$check = "SELECT * FROM `team` WHERE `name` = '$name'";
	$qry = mysql_query($check) or die ("Could not match data because ".mysql_error());
	$check_two = "SELECT * FROM `team` WHERE `username` = '$username'";
	$qry_two = mysql_query($check_two) or die ("Could not match data because ".mysql_error());
	$rows_schools= mysql_num_rows($qry_two);
	$num_rows = mysql_num_rows($qry);
	if ($num_rows > 0) {
		echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
	}else if($row_schools > 0){
		echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
	}else{
	    $sql = "INSERT INTO team (name,email,username,password) 
	        VALUES ('$name','$email','$username','$password')";
	    //echo $sql."\n";
	    mysql_query($sql)or die ("Could not match data because ".mysql_error());
	}
	unlink($location);
	echo 'Your file has been input into the database. Thank you.';
}
}
function draw_who_has_what(){
	$get_events="SELECT * FROM `team`";
	$getting=mysql_query($get_events);
			echo "<table border='1'>";
	while($get=mysql_fetch_array($getting)){
		$even=$get['name'];
		$teams=$get['id'];
		$name=$_SESSION['name'];
		$sql = "SELECT * FROM `times` ORDER BY `times`.`time_id` ASC"; //This is the Table sorting!
		$sqlnum1= mysql_query($sql) or die(mysql_error());
		$tblcl = "</td>";
			//echo '<tr><th>'.$even.'</th></tr>';
			echo '<tr><th><b>'.$even.'</b></th>';
			//echo "<tr> <th>Hour</th> <th>Slot1</th><th>Slot 2 </th> <th>Slot 3 </th> <th>Slot 4</th> <th>Slot 5</th><th>Slot 6</th><th>Slot 7</th><th>Slot 8</th><th>Slot 9</th><th>Slot 10</th></tr>";
	while($row = mysql_fetch_array($sqlnum1)) {
			if($row['team1']==$teams||$row['team2']==$teams||$row['team3']==$teams||$row['team4']==$teams||$row['team5']==$teams||$row['team6']==$teams||$row['team7']==$teams||$row['team8']==$teams||$row['team9']==$teams|$row['team10']==$teams){
				echo '<td>'.$row['event'].'</td>';
				break;
			}
	}
	echo '</tr>';
	}
echo '</table>';

}
function addevent(){		//Admin adding events
	$event= $_POST['event_name'];
	$event=stripslashes($event);
	$event = mysql_real_escape_string($event);
	$time= $_POST['time_slot'];
	$time = mysql_real_escape_string($time);
	$sql1= "INSERT INTO `event` (`event`) VALUES ('$event');";
	$check = "SELECT * FROM `event`	WHERE `event` = '$event'";
	$sql2 = "SELECT * FROM `event`	WHERE `event` = '$event'";
	$count=mysql_query($sql2);		//mysql_num_rows
	$counting=mysql_num_rows($count);

	if ($counting==0){
		$insert = mysql_query($sql1)or die("Could not insert data because ".mysql_error());
	}
	echo "The Event was added";


}
function add_time_slot(){
	$time=$_POST['time_slot'];
	$time = mysql_real_escape_string($time);
	$check= "SELECT * FROM `slots` WHERE `time_slot`='$time'";
	$check=mysql_query($check);
	$num_rows = mysql_num_rows($check);
	if ($num_rows != 0) {
		echo "Sorry, That time has already been added.";
		exit;
	}else{
		$sql= "INSERT INTO `slots` (`time_slot`) VALUES ('$time');";
		$insert = mysql_query($sql)or die("Could not insert data because ".mysql_error());
		echo 'You have added a time slot';
	}

}
function draw_new_time(){
	echo '<form method="POST" action="">
	Event:';
	draw_event_select();
	echo '
	Time Slot:<select name="time_slot">';
	$slots= "SELECT * FROM  `slots` ORDER BY `time_slot` DESC";
	$slot = mysql_query($slots)or die("Could not insert data because ".mysql_error());
	while($ren= mysql_fetch_assoc($slot)) {
		echo '<option value="'.$ren['time_slot'].'">'.$ren['time_slot'].'</option>';
	}

	echo'<input class="myButton" type="submit" value="Add Slot" name="add_event"/></form>';
	if($_POST['add_event']){	
			$event= $_POST['eventname'];
			//echo '<br/>'.$event.'<br/>';
			$event=stripslashes($event);
			$event = mysql_real_escape_string($event);
			$time= $_POST['time_slot'];
			$time =$time;
			$qry= "SELECT * FROM `times` WHERE `time_id`='$time' AND `event`='$event'";
			$qry=mysql_query($qry);
			$num_rows = mysql_num_rows($qry);
		if ($num_rows != 0) {
			echo "Sorry, that event is already at that time.";
		}else{
			$sql= "INSERT INTO `times` (`time_id`, `event`) VALUES ('$time', '$event');";
			$insert = mysql_query($sql)
				or die("Could not insert data because ".mysql_error());
			echo 'You have added a time slot';
		}
	}
}
function draw_time(){ 								//Draws Time slot selection box
	$slots= "SELECT * FROM  `slots` ORDER BY `time_slot` DESC"; 
	$slot = mysql_query($slots)or die("Could not insert data because ".mysql_error());
	while($ren= mysql_fetch_assoc($slot)) {
		if($_POST['time']==$ren['time_slot']){
			echo '<option value="'.$ren['time_slot'].'" selected="selected">'.$ren['time_slot'].'</option>';
		}else{
		echo '<option value="'.$ren['time_slot'].'">'.$ren['time_slot'].'</option>';
		}
	}
}
function drop_slot(){
	$time=$_POST['dropper'];
	$delete="DELETE FROM `slots` WHERE `time_slot` = '$time' LIMIT 1;";
	$delete_slot=mysql_query($delete)or die("Could not delete data because ".mysql_error());
	echo "Time Slot Removed";
}
function draw_drop_slot(){
echo '<form method="POST" action=""><select name="dropper" class="selectbox">';
draw_time();
echo '</select><input type="submit" class="myButton" value="Drop Slot" name="drop_slot"/></form>';
}
function change_status(){
	$enable=$_POST['enable'];
	$sql = "UPDATE `enable` SET `enabled` = '$enable'";
	$update=mysql_query($sql)or die("Could not insert data because ".mysql_error());
	draw_enable();
}
function draw_enable(){
	$en= "SELECT * FROM  `enable` ";
	$enable = mysql_query($en)or die("Could not insert data because ".mysql_error());
	while($ren= mysql_fetch_assoc($enable)) {
		if ($ren['enabled']==1){
			echo 'Currently Open';
		}else if ($ren['enabled']==2){
			echo 'Currently Closed';
		}else{
			echo 'Defaulted to Timer: ';
			check_timer();
		}
	}
}
function draw_enable_select(){
	$en= "SELECT * FROM  `enable` ";
	$enable = mysql_query($en)or die("Could not insert data because ".mysql_error());
	echo '<form method="POST" action=""><select name="enable">';
	while($ren= mysql_fetch_assoc($enable)) {
		if ($ren['enabled']==1){
			echo '<option value="1" selected="selected">Manually Open</option><option value="2">Manually Close</option><option value="3">Rely on Timer</option></select> <input type="submit" class="myButton" name="change_status" value="Change Status"/></form>';
		}else if ($ren['enabled']==2){
			echo '<option value="1">Manually Open</option><option value="2" selected="selected">Manually Close</option><option value="3">Rely on Timer</option></select> <input type="submit" class="myButton" name="change_status" value="Change Status"/></form>';
		}else{
			echo '<option value="1">Manually Open</option><option value="2">Manually Close</option><option value="3" selected="selected">Rely on Timer</option></select> <input type="submit" class="myButton" name="change_status" value="Change Status"/></form>';
			
		}
	}

}
/*--------------------------------------------Timer Functions-------------------------*/
/*-------The following functions deal with the timer. They control drawing the current timer-----*/
/*-------as well as changeing and displaying timer select boxes. Most of these functions are-----*/
/*-------called in admin_addevent unless otherwise stated   								-----*/
/*-----------------------------------------------------------------------------------------------*/
function check_timer(){			//Determins if timer is open or closed
	$today = getdate();
	$timer=0;
	$getid = mysql_query("SELECT * FROM `timer`") or die (mysql_error());
	while($time= mysql_fetch_array($getid)){
			$start_day=$time['start_day'];
			$start_year=$time['start_year'];
			$start_month=$time['start_month'];
			$end_day= $time['end_day'];
			$end_year=$time['end_year'];
			$end_month=$time['end_month'];
			$start_hour=$time['start_hour'];
			$start_minute=$time['start_min'];
			$end_hour=$time['end_hour'];
			$end_minute=$time['end_min'];
	}
	if($start_minute<10){				//Fix weird PHP stripping of 0's
		$start_minute='0'.$start_minute;
	}
	if($end_minute<10){                 //Fix weird PHP stripping of 0's
		$end_minute='0'.$end_minute;
	}
	if($start_hour>12){
		$start_hour-=12;
		$start_half='PM';
	}else{
		$start_half='AM';
	}
	if($end_hour>12){
		$end_hour-=12;
		$end_half='PM';
	}else{
		$end_half='AM';
	}
	$start_date= $start_month.'/'.$start_day.'/'.$start_year.' '.$start_hour.':'.$start_minute.$start_half;
	$ending_date=$end_month.'/'.$end_day.'/'.$end_year.' '.$end_hour.':'.$end_minute.$end_half;
	/*echo 'start:'.$start_date;
	echo 'end:'.$ending_date;*/
	$now = new DateTime();
	$dtA = new DateTime($start_date);
	$dtB = new DateTime($ending_date);
	if ( $dtA < $now) {
		$timer+=4;
	}
	if($dtB>$now){
		$timer+=1;
	}
	if($timer==5){
		echo "Open";
	}else{
		echo "Closed";
	}
}
function change_timer(){			//Changes timer
	$start_month=$_POST['start_month'];
	$start_day=$_POST['start_day'];
	$start_year=$_POST['start_year'];
	$end_month=$_POST['end_month'];
	$end_day=$_POST['end_day'];
	$end_year=$_POST['end_year'];
	$start_hour=$_POST['start_hour'];
	$start_min=$_POST['start_min'];
	$end_hour=$_POST['end_hour'];
	$end_minute=$_POST['end_min'];
	$start_min1=$_POST['start_min'];
	$end_minute1=$_POST['end_min'];
	$start_hour1=$_POST['start_hour'];
	$end_hour1=$_POST['end_hour'];
	if($start_minute<10){				//Fix weird PHP stripping of 0's
		$start_minute1='00';//.$start_minute1; //'00'.
	}
	if($end_minute<10){                 //Fix weird PHP stripping of 0's
		$end_minute1='00';//.$end_minute1; //'0'.
	}
	if($start_hour>12){ //Converts to AM/Pm
		$start_hour1-=12;
		$start_half='PM';
	}else{
		$start_half='AM';
	}
	if($end_hour>12){
		$end_hour1-=12;
		$end_half='PM';
	}else{
		$end_half='AM';
	}
	$start_date= $start_month.'/'.$start_day.'/'.$start_year.' '.$start_hour1.':'.$start_minute1.$start_half;
	$ending_date=$end_month.'/'.$end_day.'/'.$end_year.' '.$end_hour1.':'.$end_minute1.$end_half;
	$now = new DateTime();
	$dtA = new DateTime($start_date);
	$dtB = new DateTime($ending_date);
	if ( $dtA < $dtB) {
		$sql = "UPDATE `timer` SET `start_day` = '$start_day', `end_day` = '$end_day', `start_year` = '$start_year', `start_month` = '$start_month', `end_year` = '$end_year', `end_month` = '$end_month',`start_hour` = '$start_hour', `start_min`='$start_min',`end_hour`='$end_hour', `end_min`='$end_minute1'";
		//if (strlen($start_month)>0 && strlen($start_day)>0 && strlen($start_year)>0 && strlen($end_month)>0 && strlen($end_day)>0 && strlen($end_year)>0){

		$update=mysql_query($sql)or die("Could not insert data because ".mysql_error());
		get_timer();
	}else{
		echo '<div class="red">Your time is impossible. It cannot start after it ends.</div>';
		get_timer();
	}
}
function get_timer(){       //Gets the timer as plaintext
	$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row= mysql_fetch_assoc($checker)) {
		if($row['start_min']<10){				//Fix weird PHP stripping of 0's
			$start_minute='0'.$row['start_min'];
		}else{
			$start_minute=$row['start_min'];
		}
		if($row['end_min']<10){                 //Fix weird PHP stripping of 0's
			$end_minute='0'.$row['end_min'];
		}else{
			$end_minute=$row['end_min'];
		}
		$time= date("H:i:s"); 
		echo 'Time is based off of the servers time.<br/> Current Server Time is:'.$time .'<br/>';
		echo 'Current Start Date: '.$row['start_month'].'/'.$row['start_day'].'/'. $row['start_year'] .' at '.$row['start_hour'].':'.$start_minute. '<br/>';
		echo 'Current End Date:'. $row['end_month'].'/',$row['end_day'].'/'.$row['end_year'].' at '.$row['end_hour'].':'.$end_minute;
	}

}
function draw_days($which){ //1 is start day, 2 makes it look for end day
	if($which==1){
		$day='start_day';
	}else{
		$day='end_day';
	}
	$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row= mysql_fetch_assoc($checker)) {
	$days=1;
	while($days<=31){
		if($days==$row[$day]){
			echo '<option value="'.$days.'" selected="selected">'.$days.'</option>';
		}else{
			echo '<option value="'.$days.'">'.$days.'</option>';
		}
		$days++;
	}
		
	}

}
function draw_months($which){ //1 start; anything else is end
	if($which==1){
		$mon ='start_month';
	}else{
		$mon = 'end_month';
	}
	$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	$months_arr=array(1=>'January',
					  2=>'Febuary',
					  3=>'March',
					  4=>'April',
					  5=>'May',
					  6=>'June',
					  7=>'July',
					  8=>'August',
					  9=>'September',
					  10=>'October',
					  11=>'November',
					  12=>'December');
	while($row= mysql_fetch_assoc($checker)) {
	$month=1;
	while($month<=12){
			if($row[$mon]==$month){
				echo '<option value="'.$month.'" selected="selected">'.$months_arr[$month].'</option>';
			}else{
			echo '<option value="'.$month.'">'.$months_arr[$month].'</option>';
			}
			$month++;
		}
	}
}
function draw_years($which){
	$check = "SELECT * FROM `timer`";
$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
while($row= mysql_fetch_assoc($checker)) {

}
}
function draw_years_start(){

	
//echo '<option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>';
$check = "SELECT * FROM `timer`";
$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
while($row= mysql_fetch_assoc($checker)) {
	if($row['start_year']==2010){
		echo '<option value="2010" selected="selected">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['start_year']==2011){
		echo '<option value="2010">2010</option><option value="2011" selected="selected">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['start_year']==2012){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012" selected="selected">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['start_year']==2013){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013" selected="selected">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['start_year']==2014){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014" selected="selected">2014</option><option value="2015">2015</option>';
	
	}
	if($row['start_year']==2015){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015" selected="selected">2015</option>';
	
	}

}
}
function draw_years_end(){
//echo '<option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>';
$check = "SELECT * FROM `timer`";
$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
while($row= mysql_fetch_assoc($checker)) {
		if($row['end_year']==2010){
		echo '<option value="2010" selected="selected">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['end_year']==2011){
		echo '<option value="2010">2010</option><option value="2011" selected="selected">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['end_year']==2012){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012" selected="selected">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['end_year']==2013){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013" selected="selected">2013</option>
			 <option value="2014">2014</option><option value="2015">2015</option>';
	
	}
	if($row['end_year']==2014){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014" selected="selected">2014</option><option value="2015">2015</option>';
	
	}
	if($row['end_year']==2015){
		echo '<option value="2010">2010</option><option value="2011">2011</option>
			 <option value="2012">2012</option><option value="2013">2013</option>
			 <option value="2014">2014</option><option value="2015" selected="selected">2015</option>';
	
	}


}
}
function draw_hours($which){  //which is 1/2; 1== start 2 == end
	if($which=1){
			$ho='start_hour';
	}else{
		$ho='end_hour';
	}
		$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row= mysql_fetch_assoc($checker)) {
		$hour=0;
		while($hour<=23){
			if($hour==$row[$ho]){
				echo'<option value="'.$hour.'" selected="selected">'.$hour.'</option>';
			}else{
				echo'<option value="'.$hour.'">'.$hour.'</option>';
			}
			$hour++;
			}
	}
}
function draw_hours_start(){				//draws timer start hours
	$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row= mysql_fetch_assoc($checker)) {
		$hour=0;
		while($hour<=23){
			if($hour==$row['start_hour']){
				echo'<option value="'.$hour.'" selected="selected">'.$hour.'</option>';
			}else{
				echo'<option value="'.$hour.'">'.$hour.'</option>';
			}
			$hour++;
			}
	}
}
function draw_hours_end(){				//draws timer end hours
	$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row= mysql_fetch_assoc($checker)) {
		$hour=0;
		while($hour<=23){
			if($hour==$row['end_hour']){
				echo'<option value="'.$hour.'" selected="selected">'.$hour.'</option>';
			}else{
				echo'<option value="'.$hour.'">'.$hour.'</option>';
			}
			$hour++;
		}
	}
}
function draw_minutes($which){ //which is either 1 or two
	if($which==1){
		$min_half='start_min';
	}else{
		$min_half='end_min';
	}
	$check = "SELECT * FROM `timer`";
	$checker = mysql_query($check)or die("Could not insert data because ".mysql_error());
	while($row= mysql_fetch_assoc($checker)) {
		$seconds='00';
		while($seconds<=50){
			if($seconds==$row[$min_half]){
				if ($seconds<=0){
					//$seconds1= '0'.$seconds;
					$seconds1= $seconds;
				}else{
					$seconds1=$seconds;
					}
				echo'<option value="'.$seconds.'" selected="selected">'.$seconds1.'</options>';
			
			}else{
			echo'<option value="'.$seconds.'">'.$seconds.'</options>';
		}
		$seconds +=10;
	}
	}
}
function add_time_select(){
    $st_hour =$_POST['time_slot_hour'];
    $st_min =  $_POST['time_slot_min'];
    $en_hour = $_POST['slot_end'];
    $en_min = $_POST['slot_end_min'];
    echo $st_hour.':'.$st_min. '-'.$en_hour.':'.$en_min;
    $time= $st_hour.':'.$st_min. '-'.$en_hour.':'.$en_min;
    	$check= "SELECT * FROM `slots` WHERE `time_slot`='$time'";
	$check=mysql_query($check);
	$num_rows = mysql_num_rows($check);
	if ($num_rows != 0) {
		echo "Sorry, That time has already been added.";
		exit;
	}else{
	$sql= "INSERT INTO `slots` (`time_slot`) VALUES ('$time');";
			$insert = mysql_query($sql)
				or die("Could not insert data because ".mysql_error());
			echo 'You have added a time slot';
	}
}
/*-----------------------------------------------User Functions----------------------------------------*/
/*-------- The following functions allow for adding normal users as well as aministators, and also the two */
/*-------- functions that allow for password changes.													   */
function adduser(){								//Adds new user Called in Admin Manage
	$check_admin = "SELECT * FROM `members` WHERE rank = '1'";
	$qry_admin = mysql_query($check_admin) or die ("Could not match data because ".mysql_error());
	while($ren= mysql_fetch_assoc($qry_admin)) {
		$admin_email = $ren['email'];			//Gets the admin email to post when adding contact info. 
	}
	$password=$_POST['passbox'];				//Cleans strings
	$password=stripslashes($password); 
	$email=mysql_real_escape_string($_POST['email']);
	//$mpass=hash('sha512',$password);
	//$mpass=crypt($password,$salt);
	//$mpass=md5($password);
	//$password = password_hash($password,PASSWORD_BCRYPT);
	$password =  crypt($password);
	$mpass = $password;
	//$mpass = $pwdHasher->HashPassword( $password );
	/*$pwdHasher = new PasswordHash(8, FALSE);
    $mpass = $pwdHasher->HashPassword( $password );*/
	//echo $mpass;
	$user= $_POST['username'];
	$user= stripslashes($user);
	$user= mysql_real_escape_string($user);
	$name= $_POST['schoolname'];
	$name= stripslashes($name);
	$name = mysql_real_escape_string($name);


	$check = "SELECT * FROM `team` WHERE `name` = '$name'";
	$qry = mysql_query($check) or die ("Could not match data because ".mysql_error());
	$check_two = "SELECT * FROM `team` WHERE `username` = '$user'";
	$qry_two = mysql_query($check_two) or die ("Could not match data because ".mysql_error());
	$rows_schools= mysql_num_rows($qry_two);
	$num_rows = mysql_num_rows($qry);
	if ($num_rows > 0) {
		echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
	}else if($row_schools > 0){
		echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
	}else{
		$insert = mysql_query( "INSERT INTO `team` (`id`, `name`, `email`, `username`, `password`) VALUES (NULL, '$name','$email', '$user', '$mpass');")or die("Could not insert data because ".mysql_error());
			//echo 'Adding user';							//Info to send to teams. 
		echo 'Please send this info to the team:<br/>';
		echo 'The following is your login information for ' .$_POST['schoolname'].'. If you have any issues please contact '.$admin_email.'<br/>';
		echo 'Username: ' .$user.'<br/>';
		echo 'Password: ' .$password. '<br/>';

	}
}
function add_admin(){				//Adds a new admin. Called in Admin Manage
	//echo 'Adding admin';
	$name= $_POST['username'];
	$name= stripslashes($name);
	$name = mysql_real_escape_string($name);
	$password=$_POST['passbox'];
	$pass_write=$_POST['passbox'];
	$password=stripslashes($password); //injection cleaner
	//$mpass=hash('sha512',$password);
	//$mpass=crypt($password,$salt);
	//$mpass=md5($password);
	//$password = password_hash($password,PASSWORD_BCRYPT);
	$password =  crypt($password);
	$mpass= $password;
	/*$pwdHasher = new PasswordHash(8, FALSE);
	$mpass = $pwdHasher->HashPassword( $password );*/
	$user= $_POST['username'];
	$user= stripslashes($user);
	$user= mysql_real_escape_string($user);
	$check = "SELECT * FROM `members` WHERE name = '$user'";
	$qry = mysql_query($check) or die ("Could not match data because ".mysql_error());
	$num_rows = mysql_num_rows($qry);
	if ($num_rows > 0) {
		echo "Sorry, the username ".$user." is already taken. Please hit the back button and try again.<br>";
		exit;
	}else{
		echo '<br/> Please send this info to the admin:<br/>';
		echo 'Username: ' .$name.'<br/>';
		echo 'Password: ' .$pass_write. '<br/>';
		$insert = mysql_query( "INSERT INTO `members` (`name`, `password`) VALUES ('$name', '$mpass');")
		or die("Could not insert data because ".mysql_error());
		echo "<span class=\"success\">Your user account has been created!</span><br>";
	}
}
function reset_password(){			//Resents User Password Called in Admin Manage
	$user=$_POST['reset_pass'];
	$pass=$_POST['new_pass'];
	$write_pass=$pass;
	//$pass=md5($pass);/*hash('sha512',$password);*/
	//$pass= password_hash($password,PASSWORD_BCRYPT);
	$password =  crypt($password);
	$pass=$password;
	//$pwdHasher = new PasswordHash(8, FALSE);
	$user=mysql_real_escape_string($user);
	//$pass = $pwdHasher->HashPassword( $pass );
	$sql = "UPDATE `team` SET `password` = '$pass' WHERE `username` = '$user';";
	//echo $sql;
	if(strlen($user)!=0 && strlen($pass)!=0){
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	//echo $sql;
	echo '<h3>Password Changed to '.$write_pass.'</h3>';
	}else{
		echo 'You must enter a username and password.';
	}
}
function draw_reset(){                  //draws reset form for teams
	$sql = "SELECT * FROM `team` ORDER BY `name` ASC";
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	echo '<form action="" method="POST">Team:<select name="reset_pass">';
	while($row= mysql_fetch_assoc($checker)) {
		echo '<option value="'.$row['username'].'">'.$row['name'].'</option>';
	}
	echo '</select><br/>
	New Password: <input type="text" name="new_pass"/><br/><input name="change_pass" type="submit" class="myButton" value="Change Password"/>


	</form>';

}

function draw_admin_reset(){
	$sql = "SELECT * FROM `members`";
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	echo '<form action="" method="POST">Team:<select name="reset_admin_pass">';
	while($row= mysql_fetch_assoc($checker)) {
		echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
	}
	echo '</select><br/>
	New Password: <input type="text" name="new_pass"/><br/><input name="change_pass_admin" type="submit" class="myButton" value="Change Password"/>


	</form>';

}
function admin_reset_password(){
	$user=$_POST['reset_admin_pass'];
	$pass=$_POST['new_pass'];
	//echo $user;
	//echo $pass;
	$write_pass=$pass;
	//$pass=md5($pass);/*hash('sha512',$password);*/
	//$pass= password_hash($password,PASSWORD_BCRYPT);
	$password = crypt($password);
	$pass=$password;
	//$pwdHasher = new PasswordHash(8, FALSE);
	//$user=mysql_real_escape_string($user);
	//$pass = $pwdHasher->HashPassword( $pass );
	$sql = "UPDATE `members` SET `password` = '$pass' WHERE `name` = '$user';";
	//echo $sql;
	if(strlen($user)!=0 && strlen($pass)!=0){
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	//echo $sql;
	echo '<h3>Password Changed to '.$write_pass.'</h3>';
	}else{
		echo 'You must enter a username and password';
	}
}
function draw_current_teams(){
	$sql = "SELECT * FROM `team` ORDER BY `name` ASC";
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	echo '<div id="hidden_teams">';
	while($row= mysql_fetch_assoc($checker)) {
		echo '<strong>'.$row['name'].'</strong> with the username <strong>'.$row['username'].'</strong><br/>';
	}
	echo '</div>';



}
function draw_new_admin(){
	echo '
	<form method="POST" action="">
	Admin Username:<input type="text" name="username"/><br/>
	Admin Password:<input type="text" name="passbox"/><br/><input type="submit" name="add_admin" class="myButton" value="Add Admin"/>
	</form>
	';
}

//-----------------------------Draw Event Select----------------------------
function draw_event_select(){
	$sql2 = "SELECT * FROM `event` ORDER BY `event` ASC ";
	$count=mysql_query($sql2);

        echo '<select class="selectbox" name="eventname">';
        while($row = mysql_fetch_array($count)) {
        	if($_POST['eventname']){
        		$event=$_POST['eventname'];
        	}else if($_POST['event']){
        	$event=$_POST['event'];
        	}
        	if ($row['event']==$event){
        		echo '<option value="'.$row['event'].'" selected="selected">'.$row['event'].'</option>';
		}else{
	        echo '<option value="'.$row['event'].'">'.$row['event'].'</option>';

        }
		}
   echo '</select>';
}
function list_events(){
	$sql2 = "SELECT * FROM `event` ORDER BY `event` ASC ";
	$count=mysql_query($sql2);
	//echo '<ul>';
  	$id=1;
        while($row = mysql_fetch_array($count)) {

	        echo '<div class="edit" id="'.$row['id'].'">'.$row['event'].'</div>';
	        $id++;
        }
       // echo '</ul>';
}
function list_times(){
		$sql2 = "SELECT * FROM `slots` ORDER BY `time_slot` ASC ";
	$count=mysql_query($sql2);
	//echo '<ul>';
  	//$id=1;
        while($row = mysql_fetch_array($count)) {
        	$ids = $row['time_slot'];
	        echo '<div class="edit_time" id="'.$ids.'">'.$row['time_slot'].'</div>';
	        //$id++;
        }
}
function draw_time_removal(){ //draws table selection for time slots.
$sto= '<strong>';
		$stc='</strong>';
		$red = '<div id="red">';
		$enred = '</div>';
		$get_events="SELECT * FROM `event` ORDER BY `event` ASC";
		$get_events=mysql_query($get_events);
		echo '<h2>Event Times</h2>';
		echo "<table border='1'>";
	while($get=mysql_fetch_array($get_events)){
		$even=$get['event'];
		$name=$_SESSION['name'];
		$sql = "SELECT * FROM `times` WHERE `event` ='$even' ORDER BY `times`.`time_id` ASC"; //This is the Table sorting!
		$sqlnum1= mysql_query($sql) or die(mysql_error());
		$tblcl = "</td>";
			//echo '<tr><th>'.$even.'</th></tr>';
			echo '<tr><td><b>'.$even.'</b></td>';
			//echo "<tr> <th>Hour</th> <th>Slot1</th><th>Slot 2 </th> <th>Slot 3 </th> <th>Slot 4</th> <th>Slot 5</th><th>Slot 6</th><th>Slot 7</th><th>Slot 8</th><th>Slot 9</th><th>Slot 10</th></tr>";
	while($row = mysql_fetch_array($sqlnum1)) {
		$time=$row['time_id'];

			echo '<td>'; 
			echo $row['time_id'].'<form method="POST" action=""><input type="submit" name="drop_event_and_time"value="Drop This Slot"/><input type="hidden" name="time_id" value="'.$row['time_id'].'"/><input type="hidden" name="id" value="'.$row['id'].'"/></form>';
			echo $tblcl;
	}
	echo '</tr>';
	}

}
function remove_slot_from_event(){
	$id=$_POST['id'];
	$time=$_POST['time_id'];
	if($id>0){
	$delete= "DELETE FROM `times` WHERE `id` = '$id' AND `time_id`='$time' LIMIT 1";
	}else{
			$delete= "DELETE FROM `times` WHERE `time_id`='$time' LIMIT 1";
	}
	$sqlnum1= mysql_query($delete) or die(mysql_error());
	echo 'Time Deleted';


}
function event_removal($event){	//remove events
	/*Deletes it from  event and times   */
	/*echo $event;
	$times_remove="DELETE FROM `times` WHERE `event`='$event'";
	echo $times_remove;
	$event_remove="DELETE FROM `event` WHERE `event`='$event'";
	echo'<br/>'.$event_remove;
	$event_delete=mysql_query($event_remove) or die(mysql_error());
	$time_delete=mysql_query($times_remove) or die(mysql_error());
	echo 'Event Removed';*/
}
function change_table(){
	$input=$_POST['typein'];
	$qry="UPDATE `settings` SET  `tables` =  '$input' LIMIT 1" ;
	$change= mysql_query($qry);
	Echo 'Settings Changed';
}	
function check_status($number,$event,$time){
	$query="SELECT * FROM  `times` WHERE `event` ='$event' AND `time_id`='$time'";
	//echo $query;
	$sqlnum1= mysql_query($query) or die(mysql_error()); //Gets the Event row from database
while($row = mysql_fetch_array($sqlnum1)) {
	$runs=1;
	$taken=0;
	$done=false;
	while($runs<=10){
		if($row['team'.$runs]!=0){
			$taken++;
		}
		$runs++;
	}
	if($taken/$number==1){
		Echo '<td id="red">';
		echo $taken.' of '.$number.' taken';
	break;
	}else{
		echo '<td>'; 
	echo $taken.' of '.$number.' taken';
	break;
	}
}
}
function admin_draw_event_table_total(){
			$sto= '<strong>';
		$stc='</strong>';
		$red = '<div id="red">';
		$enred = '</div>';
		$get_events="SELECT * FROM `event` ORDER BY `event` ASC";
	$get_events=mysql_query($get_events);
		echo "<table border='1'>";
	while($get=mysql_fetch_array($get_events)){
		$event=$get['event'];
		
		
	$sql = "SELECT * FROM `times` WHERE `event` ='$event' ORDER BY `times`.`time_id` ASC";
	$sqlnum1= mysql_query($sql) or die(mysql_error());
	$getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die (mysql_error());
	while($getname= mysql_fetch_array($getid)){
		$id= $getname['id'];
	}
		$tblcl = "</td>";
	while($getname= mysql_fetch_array($getid)){
		$id= $getname['id'];
	}
			echo "<table border='1'>";
			echo '<h2 id="theevent">'.$event.'</h1>';
			$menu=1;
			$qry='SELECT * FROM `settings`';
			$check= mysql_query($qry);
			while ($look=mysql_fetch_array($check)){
				$table_settings=$look['tables'];
		
		}
	
			echo '<tr> <th>Hour</th>';

			while ($menu<=$table_settings){
				echo '<th>Slot '.$menu.'</th>';
				$menu+=1;
			}
			//echo "<tr> <th>Hour</th> <th>Slot1</th><th>Slot 2 </th> <th>Slot 3 </th> <th>Slot 4</th> <th>Slot 5</th><th>Slot 6</th><th>Slot 7</th><th>Slot 8</th><th>Slot 9</th><th>Slot 10</th></tr>";
	while($row = mysql_fetch_array($sqlnum1)) {
		$time=$row['time_id'];

			echo '<tr><td>'; 
			echo $row['time_id'];
			echo $tblcl;
		
		$team='team';
		$run=1;
			
		while($run<=$table_settings){
		/*echo $run.'<br/>';*/
		$team1=$team.$run;	
		/*echo $team;*/
				if($row[$team1]==-1){
		echo '<td id="closed">';
		echo 'Closed';
	//	echo '<form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="'.$run.'" name="slot"/><input type="hidden" value="'.$row['event'].'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="getthis" class="table_btn" value="Reopen"/></form>';
		echo "</td></td>"; 
	}else
			if($row[$team1]<=0){
				echo '<td id="blue">';
			echo 'Time Open';
			echo "</td></td>"; 
			}else{
			if($row[$team1] != 0){
			echo '<td id="yellow">';
			$id= $row['team1'];
			$get = mysql_query("SELECT * FROM `team` WHERE `id` = '$id'")or die (mysql_error());
			while($name = mysql_fetch_array($get)) {
				echo $name['name'];
			}
		//echo '<form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="1" name="slot"/><input type="hidden" value="'.$row['event'].'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="getthis" class="table_btn" value="Clear this"/></form>';
		echo "</td></td>";
			}
			echo "</td>";
			
		}
		
		$run+=1;
	}
	}
}
}
function draw_all_events(){
			$get_eventsnum="SELECT * FROM `event` ORDER BY `event` ASC";
	$get_eventsnumb=mysql_query($get_eventsnum);
	$eventnum=0;
	while($get=mysql_fetch_array($get_eventsnumb)){
		$eventnum++;
	}
		$get_events="SELECT * FROM `event` ORDER BY `event` ASC";
	$get_events=mysql_query($get_events);
	$floating=0;
	//echo '<div id="event_table">';
	while($get=mysql_fetch_array($get_events)){
		$even=$get['event'];
		$sto= '<strong>';
		$stc='</strong>';
		$red = '<div id="red">';
		$enred = '</div>';
		$even=mysql_real_escape_string($even);
		$even=stripslashes($even);
		$name=mysql_real_escape_string($_SESSION['name']);
		$sql = "SELECT * FROM `times` WHERE `event` ='$even' ORDER BY `times`.`time_id` ASC";
		$sqlnum1= mysql_query($sql) or die(mysql_error());
		$getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die (mysql_error());
		$tblcl = "</td>";
	while($getname= mysql_fetch_array($getid)){
		$id= $getname['id'];
	}
	if($floating==4){
	echo '<br/>';
	$floating=0;
	}
	$floating++;
	/*if($floating==0){
		echo '<div id="event_row">';
	}
			$floating++;
			echo '<div id="event_cell">';*/
	if($floating<1){
			echo '<table border="1" id="select">';
			echo '<tr><th colspan="3"><h2 id="theevent" style=\"float:right\">'.$even.'</h2></th></tr>';
	}
	else{
			echo "<table border='1'  style=\"float:left; \" id=\"select\">";
			echo '<tr><th colspan="3"><h2 id="theevent" style=\"float:right\">'.$even.'</h2></th></tr>';		
	}
		/*}else{
						echo '<div id="event_cell">';
			echo "<table border='1'>";
				echo '<tr><th colspan="3"><h2 id="theevent" style=\"float:right\">'.$even.'</h2></th></tr>';
		}*/
		
			
			$menu=1;
			$qry='SELECT * FROM `settings`';
			$check= mysql_query($qry);
		while ($look=mysql_fetch_array($check)){
				$table_settings=$look['tables'];
		
		}
	
			echo '<tr> <th>Hour</th>';
			echo '<th>Obtain</th><th>Status</th>';
	while($row = mysql_fetch_array($sqlnum1)) {
		$time=$row['time_id'];

			echo '<tr><td>'; 
			echo $row['time_id'];
			//echo $tblcl;
		
		$team='team';
		$run=1;
		//echo  'hi';
		//check_owner($even,$time,$id);
		$query="SELECT * FROM  `times` WHERE `event` ='$even' AND `time_id`='$time'";
	//echo $query;
	$sqlnum2= mysql_query($query) or die(mysql_error()); //Gets the Event row from database
while($row = mysql_fetch_array($sqlnum2)) {
	$runs=1;
	$taken=0;
	$done=false;
	$yours=0;
	while($runs<=10){
		if($row['team'.$runs]==$id){
			$yours=1;
		}
		if($row['team'.$runs]!=0){
			$taken++;
		}
		$runs++;
	}
		}
		if($yours>=1){
			//echo 'LOL';
			echo '<td id="green">';
				echo $sto.'You have this slot'.$stc;
			}else if($taken/$table_settings==1){
			Echo '<td id="red">All Slots Taken';
		}else{
		echo '<td><form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="'.$run.'" name="slot"/><input type="hidden" value="'.$even.'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="getthis" class="table_btn" value="Get this time"/></form>';
		}
		
		check_status($table_settings,$even,$time);
		echo $tblcl;

	/*if($floating>3){
		echo '</div>';
		$floating=0;
	}*/
	}


	//break;

	
	
}
	echo '</div>';
}


function searchEvent($even){						//Gets Events based off of selected events slots and creates table
		$sto= '<strong>';
		$stc='</strong>';
		$red = '<div id="red">';
		$enred = '</div>';
		$even=mysql_real_escape_string($even);
		$even=stripslashes($even);
		$name=mysql_real_escape_string($_SESSION['name']);
		$sql = "SELECT * FROM `times` WHERE `event` ='$even' ORDER BY `times`.`time_id` ASC";
		$sqlnum1= mysql_query($sql) or die(mysql_error());
		$getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die (mysql_error());
		$tblcl = "</td>";
	while($getname= mysql_fetch_array($getid)){
		$id= $getname['id'];
	}
			echo "<table border='1'>";
			echo '<h2 id="theevent">'.$even.'</h1>';
			$menu=1;
			$qry='SELECT * FROM `settings`';
			$check= mysql_query($qry);
		while ($look=mysql_fetch_array($check)){
				$table_settings=$look['tables'];
		
		}
	
			echo '<tr> <th>Hour</th>';
			echo '<th>Obtain</th><th>Status</th>';
	while($row = mysql_fetch_array($sqlnum1)) {
		$time=$row['time_id'];

			echo '<tr><td>'; 
			echo $row['time_id'];
			//echo $tblcl;
		
		$team='team';
		$run=1;
		//echo  'hi';
		//check_owner($even,$time,$id);
		$query="SELECT * FROM  `times` WHERE `event` ='$even' AND `time_id`='$time'";
	//echo $query;
	$sqlnum2= mysql_query($query) or die(mysql_error()); //Gets the Event row from database
while($row = mysql_fetch_array($sqlnum2)) {
	$runs=1;
	$taken=0;
	$done=false;
	$yours=0;
	while($runs<=10){
		if($row['team'.$runs]==$id){
			$yours=1;
		}
		if($row['team'.$runs]!=0){
			$taken++;
		}
		$runs++;
	}
		}
		if($taken/$table_settings==1){
			Echo '<td id="red">All Slots Taken';
		}else if($yours>=1){
			//echo 'LOL';
			echo '<td id="green">';
				echo $sto.'You have this slot'.$stc;
			}else{
		echo '<td><form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="'.$run.'" name="slot"/><input type="hidden" value="'.$even.'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="getthis" class="table_btn" value="Get this time"/></form>';
		}
		
		check_status($table_settings,$even,$time);
		echo $tblcl;
	}
	break;
}
function admin_draw_event_table($event){
	//$event=$_POST['eventname'];
	$name=$_SESSION['name'];
	$sql = "SELECT * FROM `times` WHERE `event` ='$event' ORDER BY `times`.`time_id` ASC";
	$sqlnum1= mysql_query($sql) or die(mysql_error());
	$getid = mysql_query("SELECT * FROM `team` WHERE `username` = '$name'") or die (mysql_error());
	while($getname= mysql_fetch_array($getid)){
		$id= $getname['id'];
	}
		echo "<table border='1'>";
		echo '<h2>'.$event.'</h1>';
		echo "<tr> <th>Hour</th> <th>Slot1</th><th>Slot 2 </th> <th>Slot 3 </th> <th>Slot 4</th> <th>Slot 5</th><th>Slot 6</th><th>Slot 7</th><th>Slot 8</th><th>Slot 9</th><th>Slot 10</th></tr>";
	while($row = mysql_fetch_array($sqlnum1)) {
		$time=$row['time_id'];
		echo "<tr><td>"; 
		echo $row['time_id'];
		echo "</td>"; 
		$check=1;
		while($check<=10){
			if($row['team'.$check]==-1){
				echo '<td id="closed">';
				echo 'Closed';
				echo '<form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="'.$check.'" name="slot"/><input type="hidden" value="'.$row['event'].'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="getthis" class="table_btn" value="Reopen"/></form>';
				echo "</td></td>"; 
			}else if($row['team'.$check]!=0){
				echo '<td id="yellow">';
				$id= $row['team'.$check];
				$get = mysql_query("SELECT * FROM `team` WHERE `id` = '$id'")or die (mysql_error());
				while($name = mysql_fetch_array($get)) {
					echo $name['name'];
				}
				echo '<form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="'.$check.'" name="slot"/><input type="hidden" value="'.$row['event'].'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="getthis" class="table_btn" value="Clear this"/></form>';
				echo "</td></td>"; 
			}else{
				echo '<td id="blue">';
				echo 'Time Open';
				echo '<form method="POST" action=""><input type="hidden" value="'.$time.'" name="time"/><input type="hidden" value="'.$check.'" name="slot"/><input type="hidden" value="'.$row['event'].'" name="event"/><input type="hidden" value="'.$id.'" name="id"/><input type="submit" name="closethis" class="table_btn" value="Close This"/></form>';
				echo "</td></td>"; 
			}
		$check++;
		}
	}
}
function addTime_admin(){
$br = '<br/>';
$event= $_POST['event'];
$id =$_POST['id'];
$slot =$_POST['slot'];
$hour = $_POST['time'];

$team='team'.$slot;
//if ($damn!=5){
$sql = "UPDATE `times` SET `$team`='0' WHERE `time_id` = '$hour' AND `event` = '$event' LIMIT 1";
//echo $sql;
$update=mysql_query($sql)or die("Could not insert data because ".mysql_error());
Echo $br.'You have opened slot '.$slot.' of '.$event. ' at '.$hour;
admin_draw_event_table($event);
//}
}
function close_slot(){
	$br = '<br/>';
	$event= $_POST['event'];
	$id = $_POST['id'];
	$slot = $_POST['slot'];
	$hour = $_POST['time'];
	$team='team'.$slot;
	//if ($damn!=5){
	$sql = "UPDATE `times` SET `$team`='-1' WHERE `time_id` = '$hour' AND `event` = '$event' LIMIT 1";
	$update=mysql_query($sql)or die("Could not insert data because ".mysql_error());
	Echo $br.'You have closed slot '.$slot.' of '.$event. ' at '.$hour;
	admin_draw_event_table($event);
//}
}
function draw_drop_time_slot(){
	echo '<form method="POST" action=""><select class="selectbox" name="slot">';
		draw_time();
	echo '</select><input type="submit" class="myButton" name="drop_event_slot" value="Drop Slot"/></form>';
}
function drop_time_slots(){
	$slot=$_POST['slot'];
	$slot=mysql_real_escape_string($slot);
	$drop_event_listing= "DELETE FROM `slots` WHERE `time_slot`= '$slot'";
	$delete_slot=mysql_query($drop_event_listing);
}
function draw_drop_teams(){
	$sql = "SELECT * FROM `team` ORDER BY `name` ASC";
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	echo '<form action="" method="POST">Team:<select name="delete_team">';
	while($row= mysql_fetch_assoc($checker)) {
		echo '<option value="'.$row['username'].'">'.$row['name'].'</option>';
	}
	echo '</select><br/>
	<input name="delete_teams" type="submit" class="myButton" value="Delete Team"/>
	</form>';

}
function drop_teams(){
    $del_team=$_POST['delete_team'];
    $del_query = "DELETE FROM `team` WHERE `username` = '$del_team'";
    //echo $del_query;
    $run_del= mysql_query($del_query)or die(mysql_error());
    //Echo 'Team Deleted';
}
function draw_table_adding_slots(){
     $sto= '<strong>';
		$stc='</strong>';
		$red = '<div id="red">';
		$enred = '</div>';
		$get_events="SELECT * FROM `event` ORDER BY `event` ASC";
		$get_events=mysql_query($get_events);
		echo '<div><h2>Add Slots to an Event</h2>';
		echo "<table border='1'>";
	while($get=mysql_fetch_array($get_events)){
		$even=$get['event'];
		$name=$_SESSION['name'];
		$sql = "SELECT * FROM `slots`"; //This is the Table sorting!
		$sqlnum1= mysql_query($sql) or die(mysql_error());
		$tblcl = "</td>";
			//echo '<tr><th>'.$even.'</th></tr>';
			echo '<tr><td><b>'.$even.'</b></td>';
			
        while($row = mysql_fetch_array($sqlnum1)) {
		$time=$row['time_slot'];
                    $table_logic="SELECT * FROM `times` WHERE `event`= '$even' AND `time_id`='$time'";
                    $magic_check=mysql_query($table_logic);
                    $num_check=mysql_num_rows($magic_check);
                    if($num_check ==0){
			echo '<td>'; 
			echo $row['time_slot'].'<form method="POST" action="">
                            <input type="submit" name="slotto_event"value="ADD This Slot"/>
                            <input type="hidden" name="time_id" value="'.$row['time_slot'].'"/>
                            <input type="hidden" name="event" value="'.$even.'"/>
                            </form>';
			echo $tblcl;
                    }
	}
	echo '</tr>';
	}
        echo '</table></div>';
}
function add_table_times(){
    //echo 'Time added to slot';	
			$event= $_POST['event'];
			//echo '<br/>'.$event.'<br/>';
			$event=stripslashes($event);
			$event = mysql_real_escape_string($event);
			$time= $_POST['time_id'];
			$time =$time;
			$qry= "SELECT * FROM `times` WHERE `time_id`='$time' AND `event`='$event'";
			$qry=mysql_query($qry);
			$num_rows = mysql_num_rows($qry);
	if ($num_rows != 0) {
		echo "Sorry, that event is already at that time.";
		
	}else{
			$sql= "INSERT INTO `times` (`time_id`, `event`) VALUES ('$time', '$event');";
			$insert = mysql_query($sql)
				or die("Could not insert data because ".mysql_error());
			echo 'You have added a time slot';
	}
}

/*----------------------------Team Manage page functions ----------------*/
function save_values(){
	$name=mysql_real_escape_string($_POST['name']);
	$email= mysql_real_escape_string($_POST['email');
	$user=mysql_real_escape_string($_POST['username']);
	$sql = "UPDATE `team` SET `name` = '$name',`email`='$email',`username`='$user' WHERE `id` = '$id';";
	$run=mysql_query($sql)or die(mysql_error());
	echo 'User Updated.';
}
function show_info($user){
	//echo $user;
	$sql = "SELECT * FROM `team` WHERE `username`='$user'";
	//echo $sql;
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	echo '<form method="POST" action="">';
	while($row= mysql_fetch_array($checker)) {
		echo 'ID: '.$row['id'].'<br/>';
		echo 'Name: <input type="text" value="'.$row['name'].'" name="name"/>';
		echo 'Email: <input type="text" value="'.$row['email'].'" name="email"/>';
		echo 'Username: <input type="text" value="'.$row['username'].'" name="username"/>';
		echo '<input type="hidden" value="'.$row['id'].'" name="id"/>';
		echo '<input type="submit" name="save" value="Save"/>';
	}
	echo '</form>';
	echo 'Please use Manage Users page to reset passwords.';

	}


/*----------------------- Mailing Functions for admin_mail.php-------------------------*/

function send_mail_to(){
    $email=mysql_real_escape_string($_POST['email']);
      $email_message=$_POST['message'];
      $email_from = 'esus@sciolyeventsignup.com';
      $email_to=$email;
      $email_subject= "Event Sign Up System";
      $headers = 'From: '.$email_from."\r\n".
      'Reply-To: '.$email_from."\r\n" .
      'X-Mailer: PHP/' . phpversion();
      @mail($email_to, $email_subject, $email_message, $headers); 
      echo '<b>Email Sent to '.$row['name'].'</b><br/>';
    

  }
function draw_team_select_email(){                  //draws reset form for teams
  $sql = "SELECT * FROM `team` ORDER BY `name` ASC";
  $checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
  echo '<form action="" method="POST">Team:<select name="email">';
  while($row= mysql_fetch_assoc($checker)) {
    echo '<option value="'.$row['email'].'">'.$row['name'].'</option>';
  }
  echo '</select><br/>
  <textarea name="message" id="emess" height="100px" width="15%"></textarea><br/>
  <input name="teams_email" type="submit" class="myButton" value="Send Mail"/>


  </form>';

}
function send_announcement(){
      $sql = "SELECT * FROM `team`";
    $checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());

    while($row= mysql_fetch_assoc($checker)) {  
      $email_message=$_POST['emessage'];
      $email_from = 'esus@sciolyeventsignup.com';
      $email_to=$row['email'];
      $email_subject= "Event Sign Up System";
      $headers = 'From: '.$email_from."\r\n".
      'Reply-To: '.$email_from."\r\n" .
      'X-Mailer: PHP/' . phpversion();
      @mail($email_to, $email_subject, $email_message, $headers); 
      echo '<b>Email Sent to '.$row['name'].'</b><br/>';
    }
}
function send_all_mail(){
$sql = "SELECT * FROM `team`";
$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());

while($row= mysql_fetch_assoc($checker)) {  
    $id=$row['id'];
    $email_from = 'esus@sciolyeventsignup.com';
    $email_to=$row['email'];
        $query = "SELECT * FROM  `times`";
    $sqlnum = mysql_query($query) or die(mysql_error());
    $email_message = "You have the following events:\n\n";
    while ($row1 = mysql_fetch_array($sqlnum)) {
            if ($row1['team1'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team2'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team3'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team4'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team5'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team6'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team7'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team8'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team9'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team10'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            }
    }
  $email_message .= "\nThanks,\nEvent Sign Up System";
  $email_subject= "Event Sign Up System";
  $headers = 'From: '.$email_from."\r\n".
  'Reply-To: '.$email_from."\r\n" .
  'X-Mailer: PHP/' . phpversion();
  @mail($email_to, $email_subject, $email_message, $headers); 
  echo '<b>Email Sent to '.$row['name'].'</b><br/>';
}

  
}
function send_mail($id,$email){
    $email_to = $email;

    $email_from = 'esus@sciolyeventsignup.com';
    $email_subject = "Event Sign Up System.";
    $check_admin = "SELECT * FROM `members` WHERE rank = '1'";

     
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    $email_message = "You have the following events:\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
    $query = "SELECT * FROM  `times`";
    $sqlnum = mysql_query($query) or die(mysql_error());

    while ($row1 = mysql_fetch_array($sqlnum)) {
     if ($row1['team1'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team2'] == $id) {
                 $email_message .= $row1['event'] . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team3'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team4'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team5'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team6'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']  ."\n";
            } else if ($row1['team7'] == $id) {
                $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team8'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team9'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            } else if ($row1['team10'] == $id) {
                 $email_message .= $row1['event']  . ' at '  . $row1['time_id']   ."\n";
            }
          }
     $email_from= 'Event Sign Up System';
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 
echo 'Email Sent';
}


?>
