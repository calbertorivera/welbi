<?php 


session_start();
require_once 'validations.php';
require_login();


//connect to the database
require_once 'database.php';
$conn = db_connect();

$title_tag = 'Error';
include_once 'shared/top.php';
?>


<main class="container">

<div class="row">
   
   <div class="col">
     <h1 class="mt-5 pt-5">We're sorry!</h1>
     <p>Something unexpected just happened. Our support team has been notified and will get right on it</p>
     <a href="main.php" class="btn btn-outline-secondary">Back to Homepage</a>
   </div>
   <div class="col">
      <img src="img/500.png" alt="500 error" style="width:800px">
   </div>

</div>
</main>

<?php 

include_once 'shared/footer.php';

?>