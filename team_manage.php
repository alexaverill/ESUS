<?php
include('header.php');
	if(strlen($_SESSION['admin_name'])>3 && $allow_run==5){
		allowed();
	}else{
		echo '<h1>You Are Not allowed here</h1>';
	}
function allowed(){
	draw_team_select();
}

function draw_team_select(){                  //draws reset form for teams
	$sql = "SELECT * FROM `team` ORDER BY `name` ASC";
	$checker = mysql_query($sql)or die("Could not insert data because ".mysql_error());
	echo '<form action="" method="POST">Team:<select name="call">';
	while($row= mysql_fetch_assoc($checker)) {
		echo '<option value="'.$row['username'].'">'.$row['name'].'</option>';
	}
	echo '</select>
	<input name="teams" type="submit" class="myButton" value="Show Team Data"/>


	</form>';

}
if($_POST['teams']){
	show_info($_POST['call']);
}

if($_POST['save']){
	save_values();
	show_info($_POST['username']);
}

?>
