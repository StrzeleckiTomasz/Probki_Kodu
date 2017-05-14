<?php
include 'init.php'; 
include 'wyglad/ogolny/header.php';
?>
                  <h2>Prywatny System Wiadomości - Konwersacja</h2>

<div>
<a href='konwersacja.php'>Konwersacja</a><br>
<a href='wysylanie.php'>Zacznij Nową Konwersacje</a>
<?php $moje_id = $user_data['Id'];?>
</div><br><br>


<div>
<?php
if(isset($_GET['hash']) && !empty($_GET['hash'])){
$hash=$_GET['hash'];
$message_query = mysql_query("SELECT `Od_Id`,`Wiadomosc` FROM `Wiadomosci` WHERE `Grupa_hash`='$hash'");

while($run_message = mysql_fetch_array($message_query)){

	$Od_Id= $run_message['Od_Id'];
	$Wiadomosc= $run_message['Wiadomosc'];
	
		$user_query = mysql_query("SELECT `Login` FROM `Uzytkownicy` WHERE `Id`='$Od_Id'");
			$run_user = mysql_fetch_array($user_query);
			$from_login = $run_user['Login'];
			
			echo "<p><b>$from_login</b><br/>$Wiadomosc</p>";
}
?>



<br/>
<form method="post">
<?php
if(isset($_POST['Wiadomosc']) && !empty($_POST['Wiadomosc']))    {
$nowa_wiadomosc = $_POST['Wiadomosc'];
mysql_query("INSERT INTO `Wiadomosci` VALUES('', '$hash', '$moje_id', '$nowa_wiadomosc')");
header('location: konwersacja.php?hash='.$hash);
}
?>
Treść Wiadomości : <br/>
	<textarea name="Wiadomosc" cols="50" rows="6"></textarea>
	<input type="submit" value="Wyslij Wiadomość" />
	</form>

	
	
	
	
	
<?php
}else{
echo "<b>Wybierz Konwersacje : </b>";
	$get_con = mysql_query("SELECT `hash`,`Uzytkownik_pierwszy`,`Uzytkownik_drugi` FROM `Wiadomosc_grupa` WHERE `Uzytkownik_pierwszy`='$moje_id' OR `Uzytkownik_drugi`='$moje_id'");
	while($run_con = mysql_fetch_array($get_con)){
	
		$hash = $run_con['hash'];
		$Uzytkownik_pierwszy = $run_con['Uzytkownik_pierwszy'];
		$Uzytkownik_drugi = $run_con['Uzytkownik_drugi'];
	

		if($Uzytkownik_pierwszy == $moje_id){
		
			$select_id = $Uzytkownik_drugi;
		}else{
		$select_id = $Uzytkownik_pierwszy;
		
		
		
		}

			$user_get = mysql_query("SELECT `Login` FROM `Uzytkownicy` WHERE `Id`= '$select_id'");
			$run_user = mysql_fetch_array($user_get);
			$select_login = $run_user['Login'];
			
			echo "<p><a href = 'konwersacja.php?hash=$hash'>$select_login</a></p>";
	}
	
	


}


?>
</div>
<BR><BR>


   <?php include 'wyglad/ogolny/footer.php';?>    
