<?php
function generate_password($pass){
	$salt=generateSalt();
	$password=crypt($pass, $salt);
	return $password;
}
function generateSalt($max = 15) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
}
function check_password($password,$stored_password){
	if(crypt($password, $stored_password) === $stored_password){
		return true;
	}else{
		return false;
	}
}



?>