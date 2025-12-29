
<?php

$connection = mysqli_connect('localhost', 'root', '', 'Top 2000');  

if (date('m') == 12) {
    $current_year = date('Y');
}
else {
    $current_year = date('Y') - 1;
};

$previous_year = $current_year - 1; 


?>