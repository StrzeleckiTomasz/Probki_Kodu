<?php


function group_exists($NazwaGrupy) {
    $NazwaGrupy= sanitize($NazwaGrupy);
  return (mysql_result( mysql_query("SELECT COUNT(`Id`) FROM `Grupowy` WHERE `NazwaGrupy` ='$NazwaGrupy' "), 0) == 1) ? true : false;
}



function change_profile_image($Id, $file_temp,$file_extn){
	$file_path='images/profil/'.substr(md5(time()), 0, 10).'.' .$file_extn;
	move_uploaded_file($file_temp, $file_path);
	mysql_query("UPDATE `Uzytkownicy` SET `Profil` = '$file_path' WHERE `Id` = ".(int)$Id);
}


function password_recovery($mode, $Email){
	$mode =sanitize($mode);
	$Email = sanitize($Email);

	$user_data = user_data(user_id_from_email($Email),  'Id', 'Imie', 'Login');
	
	if ($mode == 'Login'){
email($Email, 'Odzyskiwanie Loginu',"Witaj ".$user_data['Imie'].", \n \n  Login przypisany do konta: ".$user_data['Login'].",\n\n projekty-programistyczne.cba.pl");
	
	}else if ($mode == 'Haslo'){
          
		$generated_password = substr(md5(rand(999, 999999)), 0, 8);
		change_password($user_data['Id'], $generated_password);

	update_user($user_data['Id'], array('Haslo_odzyskanie' => '1'));

	
	email($Email, 'Odzyskiwanie hasla',"Witaj ".$user_data['Imie'].", \n \n Twoje nowe haslo: ".$generated_password.",\n\n projekty-programistyczne.cba.pl");
	}


}


function update_user($Id, $update_data){
$update = array();
	array_walk($update_data, 'array_sanitize');
	
foreach ($update_data as $field=>$data) {
$update[] = '`' . $field . '` = \'' . $data . '\'';

	   }

mysql_query("UPDATE `Uzytkownicy` SET " . implode(', ', $update) ." WHERE `Id` = $Id");

}

function change_password($Id, $Haslo){
$Id =(int)$Id;
$Haslo = md5($Haslo);

mysql_query("UPDATE `Uzytkownicy` SET `Haslo` ='$Haslo', `Haslo_odzyskanie` = 0  WHERE `Id` = $Id");

}



function user_id_from_email ($Email) {
	$Email = sanitize ($Email);
	return mysql_result(mysql_query("SELECT `Id` FROM `Uzytkownicy` WHERE `Email` = '$Email'"), 0, 'Id');
}




function  activate($Email, $Email_kod){
$Email = mysql_real_escape_string($Email);
$Email_kod = mysql_real_escape_string($Email_kod);

if(mysql_result(mysql_query("SELECT COUNT(`Id`) FROM `Uzytkownicy` WHERE `Email`='$Email' AND `Email_kod`= '$Email_kod' AND `Aktywacja`= 0"), 0) == 1){
mysql_query("UPDATE `Uzytkownicy` SET `Aktywacja` = 1 WHERE `Email` = '$Email'");	
return true;
}else {
return false;
}
}

function register_user($register_data){
	array_walk($register_data, 'array_sanitize');
	$register_data['Haslo'] = md5($register_data['Haslo']);
	
$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
$data = '\'' . implode('\', \'', $register_data) . '\'';

mysql_query("INSERT INTO `Uzytkownicy` ($fields) VALUES ($data)");
Email($register_data['Email'],'Aktywacja konta', "
		Witaj ".$register_data['Imie'].",\n\nAby aktywować swoje konto, kliknij na podany link:\n\nhttp://projekty-programistyczne.cba.pl/aktywacja.php?Email=".$register_data['Email']."&Email_kod=".$register_data['Email_kod']." \n\n -projekty-programistyczne.cba.pl");
}



function user_data($Id){

$data = array();
$Id = (int)$Id;

$func_num_args = func_num_args();
$func_get_args = func_get_args();

if($func_num_args > 1 ) {
	unset($func_get_args[0]);

$fields = '`' . implode('`, `', $func_get_args) . '`';
$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `Uzytkownicy` WHERE `Id` = $Id"));


	
	return $data;
}
}


function logged_in(){
return (isset($_SESSION['Id'])) ? true : false;
} 


function email_exists($Email) {
    $Email = sanitize($Email);
  return (mysql_result( mysql_query("SELECT COUNT(`Id`) FROM `Uzytkownicy` WHERE `Email` ='$Email' "), 0) == 1) ? true : false;
}


function user_exists($Login) {
    $Login = sanitize($Login);
  return (mysql_result( mysql_query("SELECT COUNT(`Id`) FROM `Uzytkownicy` WHERE `Login` ='$Login' "), 0) == 1) ? true : false;
}


function user_activation($Login) {
    $Login = sanitize($Login);
return (mysql_result( mysql_query("SELECT COUNT(`Id`) FROM `Uzytkownicy` WHERE `Login` ='$Login' AND `Aktywacja` = 1 "), 0) == 1) ? true : false;
}


function user_id_from_login ($Login) {
	$Login = sanitize ($Login);
	return mysql_result(mysql_query("SELECT `Id` FROM `Uzytkownicy` WHERE `Login` = '$Login'"), 0, 'Id');
}

function Login1($Login, $Haslo){
	$Id = user_id_from_login($Login);
	
	$Login = sanitize($Login);
	$Haslo = md5($Haslo);
	
	return (mysql_result(mysql_query("SELECT COUNT(`Id`) FROM `Uzytkownicy` WHERE `Login`='$Login' AND `Haslo`='$Haslo'"), 0)==1) ? $Id : false;
}
  
?>	
