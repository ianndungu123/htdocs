<!DOCTYPE html>
<html>
    <head><title>The World</title></head>
    <body style=background-color:lightblue;>
<?php
$world=array("Europe,","Africa,","Asia,","America.");
$africa=array("Kenya,","Mali,","Tunisia,","Uganda,","Angola.");
$eac=array("Nairobi,","Dodoma,","Kigali,","Kampala,","Mogadishu.");
$counties=array("Kajiado,","Nakuru,","Busia,","Nyamira,","Kiambu,","Wajir.");
$wrd=array("<h3 style=color:purple;><u>Continents</u></h3>"=>$world,"<h3 style=color:green;><u>African countries</u></h3>"=>$africa,"<h3 style=color:blue;><u>East Africa Capitals</u></h3>"=>$eac,"<h3 style=color:red;><u>Kenyan Counties</u></h3>"=>$counties);
foreach ($wrd as $key => $k) 
{
    echo $key."  ";
    for ($i=0;$i<count($k);$i++) 
    { 
        echo $k[$i]." ";
    }
    echo"<br>";
}
?>
</body>
</html>