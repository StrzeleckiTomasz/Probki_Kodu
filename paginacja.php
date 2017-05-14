<?php
       
        $query = "SELECT COUNT(*) as all_posts FROM Pliki";
        $result = mysql_query($query) or die (mysql_error());
        $row = mysql_fetch_array($result);
        extract($row);
        
        $onpage = 4; //ilość newsów na stronę
        $navnum = 7; //ilość wyświetlanych numerów stron
        $allpages = ceil($all_posts/$onpage); //wszysttkie strony to zaokrąglony w górę iloraz wszystkich postów i ilości postów na stronę
        
        //sprawdzamy poprawnośc przekazanej zmiennej $_GET['page'],  $_GET['page'] > $allpages
        if(!isset($_GET['page']) or $_GET['page'] > $allpages or !is_numeric($_GET['page']) or $_GET['page'] <= 0){
                $page = 1;
        }else{
                $page = $_GET['page'];
        }
        $limit = ($page - 1) * $onpage; //określamy od jakiego newsa będziemy pobierać informacje z bazy danych
                
        $query = "SELECT * FROM Pliki ORDER BY IdUzytkownika DESC LIMIT $limit, $onpage";
        $result = mysql_query($query) or die (mysql_error());
        
        while($row = mysql_fetch_array($result)){
               echo"</p>";
                echo "<b>Nazwa Projektu:</b> ".$row['NazwaPliku'].""; ?><div align="right"><?php echo "<b>Data Utworzenia:</b> ".$row['DataDodania']."";?></div> <?php 
                echo "<b>Kategoria:</b> ".$row['Kategoria']."</p>";
                echo "<b>Rodzaj projektu:</b> ".$row['Projekt']."</p>";
                 echo "<b>Opis: </b>".$row['OpisPliku']."</p>";

 $name3 = $row['LinkPliku'];
        
$name10 = substr($name3, 36);
?>
<a href="<?php echo $name10 ;?>  "><b><font color='red'> Pobierz</b></font></a><br>
    </p>
<?php
                echo "<hr>";
        }
        
        //zabezpieczenie na wypadek gdyby ilość stron okazała sie większa niż ilośc wyświetlanych numerów stron
        if($navnum > $allpages){
                $navnum = $allpages;
        }
        
       
        $forstart = $page - floor($navnum/2);
        $forend = $forstart + $navnum;
        
        if($forstart <= 0){ $forstart = 1; }
        
        $overend = $allpages - $forend;
        
        if($overend < 0){ $forstart = $forstart + $overend + 1; }
        
        // $forstart mogła ulec zmianie
        $forend = $forstart + $navnum;
        
        //w tych zmiennych przechowujemy numery poprzedniej i następnej strony
        $prev = $page - 1;
        $next = $page + 1;
        
      
        $script_name = $_SERVER['SCRIPT_NAME'];
        
       
        echo "<div id=\"nav1\"><ul1>";
        if($page > 1) echo "<li1><a href=\"".$script_name."?page=".$prev."\">Poprzednia</a></li1>";
        if ($forstart > 1) echo "<li1><a href=\"".$script_name."?page=1\">[1]</a></li1>";
        if ($forstart > 2) echo "<li1>...</li1>";
        for($forstart; $forstart < $forend; $forstart++){
                if($forstart == $page){
                        echo "<li1 class=\"current\">";
                }else{
                        echo "<li1>";
                }
                echo "<a href=\"".$script_name."?page=".$forstart."\">[".$forstart."]</a></li1>";
        }
        if($forstart < $allpages) echo "<li1>...</li1>";
        if($forstart - 1 < $allpages) echo "<li1><a href=\"".$script_name."?page=".$allpages."\">[".$allpages."]</a></li1>";
        if($page < $allpages) echo "<li1><a href=\"".$script_name."?page=".$next."\">Następna</a></li1>";
        echo "</ul></div><div class=\"clear\">";
?>
