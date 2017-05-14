<?php
session_start();
require 'polaczenie.php';
require_once 'uzytkownicy.php';

$aaa= uniqid('');
$uploaddir = 'Pliki/';
$max_rozmiar = 1024*10240;
$czyWyslac = 0;
$stronka = 'www.projekty-programistyczne.cba.pl/';
$kategoria=($_POST['kategoria']);
$nazwapliku=($_POST['nazwapliku']);
$rprojekt = ($_POST['rprojekt']);
$opis=($_POST['opisprogramu']);
$nazwa1 = $_FILES['plik']['name'];
$sciezka = $stronka.$uploaddir. $aaa .$nazwa1;
$id = $user_data['Id']; 

if(isset($_POST['ok']))
{
	
	if (is_uploaded_file($_FILES['plik']['tmp_name'])) 
	{
		if ($_FILES['plik']['size'] < $max_rozmiar && $_FILES['plik']['size'] >= 0) 
		{
			echo 'Odebrano plik.';
			echo '<br/>';
			$p_roz = array_pop(explode(".", $_FILES['plik']['name']));
			if($p_roz == '7z' || $p_roz == 'rar' || $p_roz == 'zip')
			{
				echo 'Format pliku zgodny.';
				echo '<br/>';
				if (!file_exists($uploaddir.$_FILES['plik']['name']))
				{
					echo'Podany plik nie ma duplikatu na serwerze.';
					echo '<br/>';
				}
				else
				{
					echo ('Plik o podanej nazwie istnieje. Zmień nazwę.');
					$czyWyslac = 1;
				}
			}
			else
			{
				echo 'Zły format pliku. Zmień na 7z,rar,zip.';
				$czyWyslac = 1;
			}
		} 
		else 	
		{
			echo 'Błąd! Plik jest za duży!';
			$czyWyslac = 1;
		}
	} 
	else 
	{
		echo 'Błąd przy przesyłaniu danych!';
		$czyWyslac = 1;
	}




if ($czyWyslac == 0)
{
		move_uploaded_file($_FILES['plik']['tmp_name'],$uploaddir. $aaa. $_FILES['plik']['name']);
	$conn = mysql_connect('mysql.cba.pl', '*********', '*********') or die('Error connecting to mysql');
    mysql_select_db('**********');
	$zapytanie = mysql_query
		("INSERT INTO Pliki (IdUzytkownika, NazwaPliku, Kategoria, Projekt, LinkPliku, OpisPliku) 
			VALUES('$id', '$nazwapliku',  '$kategoria', '$rprojekt', '$sciezka', '$opis')");
}

}

?>	
