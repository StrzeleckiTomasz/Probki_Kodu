?php
include 'init.php'; 
include 'wyglad/ogolny/header.php';
?>
                  <h2>Prywatny System Wiadomości - Nowa Konwersacja </h2>

<div>
<a href='konwersacja.php'>Konwersacja</a><br>
<a href='wysylanie.php'>Zacznij Nową Konwersacje</a>
</div><br><br>
<?php



if(isset($_GET['Uzytkownik']) && !empty($_GET['Uzytkownik'])){
?>
	<form method="post">
	<?php
	
	if(isset($_POST['Wiadomosc']) && !empty($_POST['Wiadomosc'])){
	$moje_id =$user_data['Id'];
	$Login = $_GET['Uzytkownik'];
	$random_number = rand();
	$Wiadomosc= $_POST['Wiadomosc'];
	$check_con = mysql_query("SELECT `hash` FROM `Wiadomosc_grupa` WHERE (`Uzytkownik_pierwszy`='$moje_id' 
	AND `Uzytkownik_drugi` ='$Login') OR (`Uzytkownik_pierwszy`='$Login' AND `Uzytkownik_drugi`='$moje_id') ");
	
	if(mysql_num_rows($check_con)==1){
	echo "<p>Conversation already started ! </p>";
	
	}else{
		mysql_query("INSERT INTO `Wiadomosc_grupa` VALUES ('$moje_id', '$Login', '$random_number')");
		mysql_query("INSERT INTO `Wiadomosci` VALUES ('','$random_number', '$moje_id', '$Wiadomosc')");
		echo "<p>Conversation Started!</p>";
	
	}}
	?>
	Enter Message : <br/>
	<textarea name="Wiadomosc" cols="60" rows="7"></textarea>
	<br/><br/>
	<input type="submit" value="Wyslij Wiadomość" />
	</form>
	
	<?php
	}else{
	echo" <b>Wybierz Uzytkownika</b>";
	
	$user_list = mysql_query("SELECT `Id`, `Login` FROM `Uzytkownicy`");
	while($run_user = mysql_fetch_array($user_list)){
	
	$Id = $run_user['Id'];
	$Login = $run_user['Login'];
	
	echo "<p><a href = 'wysylanie.php?Uzytkownik=$Id'>$Login</a></p>";
	}}
	?>

<BR><BR>


   <?php include 'wyglad/ogolny/footer.php';?>      

	
