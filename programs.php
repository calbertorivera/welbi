<?php 

session_start();
require_once 'validations.php';


//connect to the database
require_once 'database.php';
$conn = db_connect();


$title_tag = 'Programs List';
include_once 'shared/top.php';


//SERVER PARAMETERS
require_once 'backend_cred.php';

?>

<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, URL_ATTENDEES);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, BASIC_AUTH_USER.":".BASIC_AUTH_PASSWORD);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$programs = curl_exec($ch);
curl_close($ch);  
$json = json_decode($programs , true);

?>

<table class="table table-striped fs-6 mt-4">
    <thead>
        <tr>
            <th   class="col d-none d-sm-table-cell">ID</th>
            <th   class="col">Name</th>
            <th   class="col">Location</th>         
            <th   class="col-lg-1 d-none d-sm-table-cell">All day?</th>
            <th   class="col-lg-2">Start</th>
            <th   class="col-lg-2">End</th>
            <th   class="col d-none d-sm-table-cell">Tags</th>           
            <th   class="col d-none d-sm-table-cell">Attendees</th>       
            <th  class="col-sd-1" scope="col-1">View</th>    
        </tr>
    </thead>
    <tbody>
        <?php foreach($json as $program) {?>
        <tr>
            <th scope="row" class="col d-none d-sm-table-cell" ><span class="d-inline-block text-truncate" style="max-width: 90px;"> <?php echo $program['id']?></span></th>
            <td scope="row" > <?php echo $program['name']?></td>
            <td scope="row" > <?php echo $program['location']?></td>          
            <td scope="row" class="col-lg-1 d-none d-sm-table-cell" > <?php echo ($program['allDay']?"Yes":"No")?></td>
            <td scope="row" > <?php echo $program['start']?></td>
            <td scope="row" > <?php echo $program['end']?></td>
            <td scope="row" class="col d-none d-sm-table-cell" > <?php echo $program['tagsSplitted']?></td>          
            <td scope="row" class="col d-none d-sm-table-cell"> <?php echo $program['attendeesCount']?></td>            
            <td><a href='attendees.php?program_id=<?php echo $program['id']?>' class='btn btn-secondary' ><span class="visually-hidden">View </span><i class="bi bi-card-checklist"></i></a></td>
         </tr>
        <?php } ?>
    </tbody>
</table>




<?php 

include_once 'shared/footer.php';

?>