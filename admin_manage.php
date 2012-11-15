<?php

include('header.php');
if(strlen($_SESSION['admin_name'])>3 && $allow_run==5){
	allowed();
}else{
	echo '<h1>You Are Not allowed here</h1>';
}
function allowed(){
echo '<h1>Manage Users</h1><div class="center"><h2>Add New Users</h2></div>
<SCRIPT LANGUAGE="JavaScript">
	function randomPassword(length)
	{
		chars = "abcdefghjlmnpqrstvwyABCDEFGHIJLMNPQRSTVWY23456789";
		pass = "";
		for(x=0;x<length;x++)
	{
		i = Math.floor(Math.random() * 62);
		pass += chars.charAt(i);
	}
		return pass;
	}
	function formSubmit()
	{
		passform.passbox.value = randomPassword(passform.length.value);
		return false;
	}
	//  End -->
</script>';
require_once 'source/reader.php';

echo '<div id="columns"><div id="bulk"><h3>Bulk Upload Users</h3>How your Excel sheet (.xls) should look:<!--<table style="margin:0px;"><tr><td>School Name</td><td>Username</td><td>Password</td></tr><tr><td>A schools name</td><td>Username School Name no spaces</td><td>Plaintext Password</td></tr></table>-->';
echo'<br/><a href="source/example.xls">Download Example</a><form enctype="multipart/form-data" action="" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
Choose a sheet to upload: <input name="uploadedfile" id="file" type="file" /><br/>
<input type="submit" name="up" value="Upload File" />
</form>  <script> $(document).ready(function() {
       $("#file").kendoUpload();
   });</script>';
if($_POST['up']){
	/*if ($_POST['uploadedfile']>0){*/
	upload();
	/*}else{
	echo 'Please Select a file';
	}*/
}
?>
<br/></div><!--<div id="float">Or</div>--><div id="individual">
<h3>Create a new user</h3><form name="passform" action="" method="post">
<dl>
  <dt>
    <label for="schoolname">School</label>
  </dt>
  <dd>
<input type="text" name="schoolname"id="schoolname" size="25" /> <span class="hint">For example Kingwood Highschool</span>
  </dd>
  <dt>
  <label for="username">Username</label>
  </dt>
  <dd>
  <input type="text" name="username" id="username" size="25" /><span class="hint">For example kingwoodhs.</span><br/>
  </dd>
   <dt>
    <label for="email">Email</label>
   </dt>
   <dd>
<input type="text" name="email" id="email" size="25"/>
<span class="hint">example@example.com.</span><br/>
</dd>
    <dt>
  		<label for="psw">Password</label>
  </dt>
  <dd>
  <input type="text" name="passbox" id="psw" size="25"/><span class="hint">Something between 5-10 characters, 7 is a good choice.</span>
  </dd>
  <dt>
  	<label for="submit"></label>
  	</dt>
  	<dd>
  	<input type="submit" class="myButton" value="Add user" name="adduser"/> 
  	</dd>
</dl>
</form>
<?php
	
	
		
		if ($_POST['adduser'])
		{ 
		    adduser();
		}
	echo '</div></div>';
		if($_POST['delete_teams']){
		    drop_teams();
		}
	echo '<br/><br/><br/><br/><br/><br/><br/><br/><div id="bulk1"><h2>Reset Passwords</h2>';
		if($_POST){
			draw_reset();
		}else{
			draw_reset();
		}
	echo '<h3><a id="drop_team">Delete Teams (click here to view)</a></h3><div id="drop_box_t">';
	draw_drop_teams();
	echo'</div>';
	echo '<br/><h2>Add New Administrator</h2>';
	draw_new_admin();
	echo '<h3>Reset Admin Password</h3>';
	draw_admin_reset();
	/*'<br/><div class="center1"><h2>Currently Registered Teams</h2><div>';*/

	echo '</div><div id="individual1"> <h2 id="hideteam">Currently Registered Teams (Click to View)</h2>';
	draw_current_teams();
	echo '<br/>or <a href="export_members.php">Download all Teams</a><br/></br/><br/><br/><br/><br/><br/></br/><br/><br/></div>';

}
	if($_POST['submitted']){
		addevent();
	}

	if($_POST['time']){
		change_timer();
	}	

	if($_POST['change_pass']){
		reset_password();
	}

	if($_POST['change_pass_admin']){
		admin_reset_password();
	}

	if($_POST['add_admin']){
		add_admin();
	}
	
	if($_POST['add']){
		addevent();

	}

echo '<div id="footer"><a href="http://violingeek12.com/esus/">Created by Alex Averill</a></div>';
include('footer.php');

?>
