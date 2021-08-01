<?php 

session_start();
require_once 'validations.php';
require_login();

//connect to the database
require_once 'database.php';
$conn = db_connect();
?>


<?php
$title_tag = 'Home';
include_once 'shared/top.php';
?>


<img src="img/splash.jpg" alt="" class='img-fluid'/>



<?php

include_once 'shared/footer.php';

?>