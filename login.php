<?php session_start();include('header.php');?>
	<h1>Login</h1>
		<div class="user_info">
			<form method="POST" action="">
				<label for="user">Username</label><input type="text" name="user" size="25"/><br/>
				Password<input type="password" name="pass" size="25"/><br/>
				<input class="myButton" value="Login" type="submit" />
				<input type=hidden name=submitted value=1> 
			</form>
		</div>
	<div id="add_login">
		<a href="admin_login.php">Admin Login</a>
	</div>

<?php 
	if($_POST['submitted'])
	{
		check($install);

	}
function check($install){
		echo '<META HTTP-EQUIV=Refresh CONTENT=".01; URL=index.php">';
		
		$user=$_POST['user']; 
		$password=$_POST['pass'];
		$time = getdate();
		$user= mysql_real_escape_string($user);
		$pass= crypt($password);

		$sql="SELECT * FROM  `team` WHERE username =  '$user'";
		$result=mysql_query($sql)or die(mysql_error());

		while($row= mysql_fetch_assoc($result)) {
			$stored = $row['password'];
		}

		if(crypt($password,$stored)==$stored){
			$_SESSION['name']=$user; 
			$_SESSION['time']= $time;
			$_SESSION['install']=$install;
			echo 'Thanks for logging in '. $_SESSION['name'];
		}
		else {
			echo "Wrong Username or Password";
		}
}
?>
<?php include('footer.php');?>
