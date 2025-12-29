<head>
    <link rel="stylesheet" href="./styles.css">
</head>

<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '
<u>Uitleg </u> 
<p>
<ol>
<li>Importeer de database (bijv. vanuit het Excel-bestand op de website van Top2000. <br>
<strong>Denk om de rechte aanhalingstekens bij het importeren!</strong><br>
Voor kolommen zie jaren v.a. 2025)</li>
<li>Voeg daarin de kolommen <i>Notering_ly</i> toe en stel kolom <i>Notering</i> in als (Auto Increment).  
<li> Druk op de knop hieronder om de noteringen uit het jaar ervoor op te halen en weg te schrijven <br>
naar de database van het huidige jaar. *
</ol>
* Houd er rekening mee dat bij sommige titels <i>(Albumversie)</i> is toegevoegd, waardoor er geen notering wordt gevonden. 
<p>';


require('connection.php');

    $allHits= "SELECT * FROM Top2000_$current_year";
    $all_query = mysqli_query($connection, $allHits);
    $array_query = mysqli_fetch_all($all_query, MYSQLI_ASSOC);


echo '
<form method="post">

<input type="submit" id="all_results" value="Update noteringen vorig jaar" name="update">
<p>';

 if (isset($_POST['update'])) {
   for ($i=0; $i < sizeof($array_query); $i++) {
        $update_not_ly = "UPDATE Top2000_$current_year SET Notering_ly =";
        $update_not_ly .= ' (SELECT Notering FROM Top2000_' . $previous_year . ' WHERE Titel = "';
        $update_not_ly .=  trim($array_query[$i]['Titel']);
        $update_not_ly .= '" AND Artiest = "';
        $update_not_ly .= trim($array_query[$i]['Artiest']);
        $update_not_ly .= '" AND Jaar = "'; 
        $update_not_ly .= trim($array_query[$i]['Jaar']);
        $update_not_ly .= '") WHERE Notering = ';
        $update_not_ly .=  $array_query[$i]['Notering'];
   
    $update_query = mysqli_query($connection, $update_not_ly);

   }};

   echo '</form>';
   