<?php session_start(); 
echo '<META HTTP-EQUIV=Refresh CONTENT=".01; URL=index.php">';
include('header.php');
$user=$_POST['user']; 
$password=$_POST['pass'];
$time = getdate();
// Stopish MySQL injection 

$user = stripslashes($user);
//$password = stripslashes($password);
$user= mysql_real_escape_string($user);
$user= htmlspecialchars(trim($user));
//$mpass=hash('sha512',$password);
//$mpass=crypt($password,$salt);'

$mpass=md5($password);
$sql="SELECT * FROM  `team` WHERE username =  '$user' AND password='$mpass'";
$result=mysql_query($sql);

if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$count=mysql_num_rows($result);

if($count==1){
	$_SESSION['name']=$user; 
	$_SESSION['time']= $time;
	$_SESSION['install']=$install;
	//session_regenerate_id();
	echo 'Thanks for logging in '. $_SESSION['name'];
}
else {
	echo "Wrong Username or Password";
}

/*
$pwdHasher = new PasswordHash(8, FALSE);
$sql="SELECT password FROM  `team` WHERE username =  '$user'";
$get_status="SELECT logged FROM `team` WHERE username = '$user'";
$get_status=mysql_query($get_Status);
if($get_status['logged']==1){
	echo 'You are logged in already. Would you like to totally log out?';
}else{
// $hash is what you would store in your database
$hash = $pwdHasher->HashPassword( $password );

$result=mysql_query($sql);
$hash=mysql_fetch_array($result);
//echo $hash['password'];
$hashed=$hash['password'];
// $hash would be the $hashed stored in your database for this user
$checked = $pwdHasher->CheckPassword($password, $hashed);
if ($checked) {
    	$_SESSION['name']=$user; 
	$_SESSION['time']= $time;
	$_SESSION['install']=$install;
	//session_regenerate_id();
	echo 'Thanks For logging in '. $_SESSION['name'];
} else {
    echo "Wrong Username or Password";
}
}*/
ob_end_flush();
include('footer.php');
?>

