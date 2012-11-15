<?php include('header.php');?>
<h1>Administrator Login</h1>
<div class="user_info">
<form method="POST" action="">
<label for="user">Username</label><input type="text" name="user" size="25"/><br/>
Password<input type="password" name="pass" size="25"/><br/>
<input class="myButton" value="Login" type="submit" />
<input type=hidden name=submitted value=1> 
</form>
</div>
<?php 
if($_POST['submitted']){
	check($install);
}
function check($install){
	echo '<META HTTP-EQUIV=Refresh CONTENT=".01; URL=index.php">';
	$user=$_POST['user']; 
	$password=$_POST['pass'];
	$user = stripslashes($user);
	$password = stripslashes($password);
	$sql="SELECT * FROM  `members` WHERE name =  '$user'";
	$result=mysql_query($sql);
	while($row= mysql_fetch_assoc($result)) {
		$stored = $row['password'];
	}

	if(crypt($password,$stored)==$stored){
		$_SESSION['admin_name']=$user; 
		$_SESSION['install']=$install;
		echo 'Thanks For logging in '. $_SESSION['admin_name'];
	}else {
		echo "Wrong Username or Password";
	}

	ob_end_flush();
}

echo '<div id="footer"><a href="http://violingeek12.com/esus/">Created by Alex Averill</a></div>';
include('footer.php');
?>
