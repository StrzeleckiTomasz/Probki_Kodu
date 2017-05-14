...
//pamietac aby stworzyc folder 'profil'

	<div class ="profil">
<?php
	if(isset($_FILES['Profil']) === true){
	   if (empty($_FILES['Profil'] ['name']) === true) {
		echo 'Prosze wybrać plik!';
	   }else{
		
		$allowed = array('jpg', 'jpeg', 'gif', 'png');

		$file_name = $_FILES['Profil'] ['name'];
		$file_extn = strtolower(end(explode('.', $file_name)));
		$file_temp = $_FILES['Profil'] ['tmp_name'];
		
		if (in_array($file_extn, $allowed) === true) {
			change_profile_image($session_user_id, $file_temp, $file_extn );
			header('Location: ' . $current_file);	
			exit();
	}else {
			echo 'Nieprawidłowy typ pliku. Dozwolony:';
			echo implode(', ', $allowed);
		      }
		
	     }
	}
	
	if (empty($user_data['Profil']) === false){
	echo '<img src="', $user_data['Profil'], '" alt = "', $user_data['Imie'], '\'s Profile Image"  height="140" width="188">';

	}
?>
	<form action = "" method="post" enctype="multipart/form-data"> 
	<input type ="file" name ="Profil"><input type ="submit">
	</form>

	</div>
  
  
  ......
