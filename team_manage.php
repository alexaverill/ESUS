<?php
include('header.php');
	/*if(strlen($_SESSION['admin_name'])>3 && $allow_run==5){
		allowed();
	}else{
		echo '<h1>You Are Not allowed here</h1>';
	}*/
	allowed();
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
if($_POST['save']){
	save_values();
	show_info($_POST['username']);
}
function save_values(){
	$name=mysql_real_escape_string($_POST['name']);
	$email= mysql_real_escape_string($_POST['email');
	$user=mysql_real_escape_string($_POST['username']);
	$sql = "UPDATE `team` SET `name` = '$name',`email`='$email',`username`='$user' WHERE `id` = '$id';";
	$run=mysql_query($sql)or die(mysql_error());
	echo 'User Updated.';
	}
?>
