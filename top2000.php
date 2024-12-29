<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 2000</title>
    <link rel="stylesheet" href="./styles.css">

</head>
<body>


<?php

require('connection.php');

$uniqueYears = "SELECT DISTINCT Jaar from Top2000_2024 ORDER BY Jaar ASC";
$showYears = mysqli_query($connection, $uniqueYears);

?>

<div class="main">

<div class="segment">

<form action="./top2000.php" method="post">
  <label for="notering">Ga direct naar een notering</label><br>
  <input type="number" id="notering" min=1 max= 2000 placeholder = '1-2000' name="notering"><br><br>
</form>

<form action="./top2000.php" method="post">
<label for="title_artist">Zoek op titel / artiest</label><br>
  <input type="text" id="title_artist" name="title_artist"><br><br>
</form>

<form action="./top2000.php" method="post">

<label for="jaar">Alle noteringen uit een jaar</label><br>
<select name="jaar" onchange="this.form.submit()">
    <option selected disabled>Selecteer jaar</option>
<?php 
while ($row = mysqli_fetch_array($showYears)) {
    echo '<option value=' . $row[0] . '>' . $row[0] . '</option>';
}

?>
</select>
</form>

</div>
</div>

<br><br>
<form action="./top2000.php" method="post">
  <input type="submit" value='Toon gehele lijst' id="all_results" name="all_results"><br><br>
</form>



<?php 

if (!empty($_POST['notering']) && $_POST['notering'] > 0 && $_POST['notering'] <= 2000 ) {
    $allHits = 'SELECT * from Top2000_2024 WHERE Notering= ' . $_POST['notering'];
}

elseif (!empty($_POST['title_artist'])) {
    $title_artist = $_POST['title_artist'];
    $allHits = "SELECT * from Top2000_2024 WHERE Artiest LIKE '%$title_artist%'";
    $allHits .= " OR Titel LIKE '%$title_artist%' ORDER by Notering ASC";
}

elseif (!empty($_POST['jaar'])) {
    $allHits = 'SELECT * from Top2000_2024 WHERE jaar = ' . $_POST['jaar'] . ' ORDER by Notering ASC';
}

else {
    $allHits = "SELECT * from Top2000_2024 ORDER by Notering ASC";

}

$showAllHits = mysqli_query($connection, $allHits);

$results = mysqli_num_rows($showAllHits); 

if ($results == 0 ) {
    echo '<i>Geen resultaten gevonden</i>';
}

else {


echo '
<div class="container_table">'; 

if ($results > 1 && $results < 2000)  {
    echo '<div id="results">Aantal resultaten: ' . $results . '</div>';
        }

echo '
<table>
<tr>
<th class="width_cell">Nr.</th>
<th>Titel</th>
<th>Artiest</th>
<th>Jaar</th>
</tr>
';

while ($row = mysqli_fetch_assoc($showAllHits)) {
   
  $top_notering = $row['Notering'];
  $top_title = $row['Titel'];
  $top_artist = $row['Artiest'];
  $top_year = $row['Jaar'];

echo '
<tr>
<td>'.$top_notering. '</td>
<td>'.$top_title. '</td> 
<td>'.$top_artist. '</td> 
<td>'.$top_year. '</td> 
</tr>';


}

echo '
</table>
</div>';
}

?>
    
</body>
</html>