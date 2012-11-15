<?php 
//This is Version: 2.0.2.0
//Version number setup: (Major version).(Minor version).(Revision number).(Build number)
//Versions will update based on: 
//bug fixes (Build Number)
//Revisions will update if bug fixes get large (10?)
// Feature Addtions (Minor Version)
//More then one new feature(major version)
//Builds shoudl be updated as files are changed or every few weeks
error_reporting(0);             //Error reporting, if you are having problems change 0 to E_ALL
session_start();
require('functions.php');
require('database.php');      //Links to database
// Database info. here since database.php is dynamically generated
  $link = mysql_connect($data_host, $data_username,$data_password)
    or die ("Could not connect to mysql because ".mysql_error());
  mysql_select_db($name_database)
    or die ("Could not select database because ".mysql_error());
  $tblcl = "</td><td>";
  // Checks to determine if new_admin.php or install.php is there, and if not allows for program to be used.
  $new_admin_file = 'new_admin.php';
	$install_file='install.php';

  if (file_exists($new_admin_file)||file_exists($install_file)) 
  {
      echo 'Please remove the admin account page or the install page to continue using this installation';
      $allow_run  = 0; //used later to see if this step happened
  } 
  else 
  {
      $allow_run = 3;     //half of verification step for if rest of ESUS can show things
  }
$check_install="SELECT * FROM `settings`";            
$check_install=mysql_query($check_install);
while($checking_install=mysql_fetch_array($check_install))
{
    $install_value=$checking_install['install'];
}
if($_SESSION['install']==$install_value)
{
  $allow_run  +=2;             //Second step of verification, makes sure stored Install is same as this install, avoid cross esus issues
}

//$today = getdate();
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
    if($start_minute<10)
    {				//Fix weird PHP stripping of 0's
    	$start_minute='0'.$start_minute;
    }
    if($end_minute<10)
    {                 //Fix weird PHP stripping of 0's
    	$end_minute='0'.$end_minute;
    }
    if($start_hour>12)
    {
      $start_hour-=12;
      $start_half='PM';
    }else
    {
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
  $now = new DateTime();
  $dtA = new DateTime($start_date);
  $dtB = new DateTime($ending_date);
    if ( $dtA < $now) {
    $timer+=4;
    }
    if($dtB>$now){
    $timer+=1;
    }
    if($timer>=5){
    	$time_left=6;
    	
    }else{
    	$time_left=0;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Science Olympiad Event Sign Up</title>

<link href="source/main.css" rel="stylesheet" type="text/css" />
<!-- Add the Kendo styles to the in the head of the page... -->
<link href="source/kendo.common.min.css" rel="stylesheet" />
<link href="source/kendo.kendo.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="source/images/favicon.ico" >
<!-- ...then paste the Kendo scripts in the page body (before using the framework) -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script src="source/kendo.all.min.js"></script>
<script src="source/jquery.jeditable.js" type="text/javascript"></script>
<script type="text/javascript" >
$(document).ready(function() {
$('#drop_box').hide();
$('#hidden_teams').hide();
$('#drop_box_t').hide();
// toggles the slickbox on clicking the noted link �
$('#drop').click(function() {
	$('#drop_box').toggle(400);
	return false;
	});
// toggles the slickbox on clicking the noted link �
$('#hideteam').click(function() {
	$('#hidden_teams').toggle(400);
	return false;
	});
$('#drop_team').click(function() {
	$('#drop_box_t').toggle(400);
	return false;
	});
});
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}


function prepareInputsForHints() {
  var inputs = document.getElementsByTagName("input");
  for (var i=0; i<inputs.length; i++){
    inputs[i].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    inputs[i].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
  var selects = document.getElementsByTagName("select");
  for (var k=0; k<selects.length; k++){
    selects[k].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    selects[k].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
  var textareas = document.getElementsByTagName("textarea");
  for (var m=0; m<textareas.length; m++){
    textareas[m].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    textareas[m].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
}
addLoadEvent(prepareInputsForHints);
$(function() {
  $(".edit").editable("updated_events.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      width : "500",
      loadtext  : 'Updating…'
  });
});
$(function() {
  $(".edit_time").editable("updated_times.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      width : "500",
      loadtext  : 'Updating…'
  });
});
$(function() {
  $(".teamedit").editable("update_users.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      width : "500",
      loadtext  : 'Updating…'
  });
});
</script>
</head>

<body>
	<div id="header">
    	<div class="logo"><img src="source/images/logo.png" border="0" alt="" title="" /></div>       
    </div>
<div id="main_body">

<div id="menu"><div id="spacer"></div>
<ul>
<?php

if(strlen($_SESSION['admin_name'])>1 && $_SESSION['install']==$install_value){
echo'<li><a href="index.php" class="menu_link">Team View</a></li>
	<!--<li><a href="admin.php" class="menu_link"> Admin Area</a></li>-->
	<li><a href="admin_manage.php" class="menu_link">Control  Users</a></li>
	<li><a href="admin_mail.php" class="menu_link">Emailing</a></li>
	<li><a href="admin_addevent.php" class="menu_link">Control Events and Timer</a></li>
	<li><a href="admin_event.php" class="menu_link">View Events</a></li>';
          echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>';
}else if (strlen($_SESSION['name'])>1){
  echo'<li><a href="index.php" class="menu_link">Select Event Times</a></li>
    <li><a href="view.php" class="menu_link">View Your Event Times</a></li>';
}else if(strlen($_SESSION['name'])>1){
				echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>'; //</ul></div>
				}else if(strlen($_SESSION['admin_name'])>1){
					echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>';
				}else{
				echo '<li><a href="login.php" class="menu_link">Login</a></li>';
				}		
				?>
</ul>

           </div>
<div id="sep"></div>
<div id="page"><div id="content">
