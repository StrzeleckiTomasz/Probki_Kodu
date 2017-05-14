...


   <h2>Rejestracja</h2>

<?php
if (isset($_GET['success']) && empty($_GET['success'])){
echo 'Twoje konto zostało zarejestrowane pomyślnie! Proszę sprawdzić pocztę , aby aktywować swoje konto';
}else{

if(empty($_POST) === false && empty($errors) === true) {
	$register_data = array( 
		'Login' 	 => $_POST['Login'],
		'Haslo'		 => $_POST['Haslo'],
		'Imie'	 => $_POST['Imie'],
		'Nazwisko'	 => $_POST['Nazwisko'],
		'Email'		 => $_POST['Email'],
                'Email_kod'  => md5($_POST['Login'] + microtime())

	);
	register_user($register_data);
	header('Location: rejestracja.php?success');
	exit();

}else if (empty($errors) === false){
	echo output_errors($errors);

}


?>
          
<form action ="" method = "post">
	<ul>
		Login*:<br>
		<input type ="text" name="Login">
		
		Hasło*:<br>
		<input type ="password" name="Haslo">

		Powtórz Hasło*:<br>
		<input type ="password" name="Haslo_v">

		Imie*:<br>
		<input type ="text" name="Imie">

		Nazwisko:<br>
		<input type ="text" name="Nazwisko">
		
		Email*:<br>
		<input type ="text" name="Email"><br>

		<input type ="submit" value="Zarejestruj">


	</ul>
</form>


   <?php
}
 include 'wyglad/ogolny/footer.php';?>      
