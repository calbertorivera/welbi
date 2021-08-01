<?php 


session_start();
require_once 'validations.php';
require_login();


//connect to the database
require_once 'database.php';
$conn = db_connect();


//SERVER PARAMETERS
require_once 'backend_cred.php';


$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    //get the form inputs   
    $name =  trim(filter_var($_POST["name"], FILTER_SANITIZE_STRING));
    $firstName = trim(filter_var($_POST["firstName"], FILTER_SANITIZE_STRING));
    $lastName  = trim(filter_var($_POST["lastName"], FILTER_SANITIZE_STRING));
    $preferredName = trim(filter_var($_POST["preferredName"], FILTER_SANITIZE_STRING));
    $status      = trim(filter_var($_POST["status"], FILTER_SANITIZE_STRING));
    $room      = trim(filter_var($_POST["room"]));
    $levelOfCare    = trim(filter_var($_POST["levelOfCare"], FILTER_SANITIZE_STRING));
    $ambulation       = trim(filter_var($_POST["ambulation"], FILTER_SANITIZE_STRING));
    $birthDate      = trim(filter_var($_POST["birthDate"], FILTER_SANITIZE_STRING));
    $moveInDate    = trim(filter_var($_POST["moveInDate"], FILTER_SANITIZE_STRING));




    // create an associative array on the user inmput
    $new_resident =[];
    $new_resident['name'] = $name;
    $new_resident['firstName'] = $firstName;
    $new_resident['lastName'] = $lastName;
    $new_resident['preferredName'] = $preferredName;
    $new_resident['status'] = $status;
    $new_resident['room'] = $room;
    $new_resident['levelOfCare'] = $levelOfCare;
    $new_resident['ambulation'] = $ambulation;
    $new_resident['birthDate'] = $birthDate;
    $new_resident['moveInDate'] = $moveInDate;


     // validate the inputs
     $errors = validate_resident($new_resident);

  //if there are no errors, insert into db
  if(empty($errors))
  {

     try
     {
       
        $new_resident['birthDate'] = [];
        $new_resident['moveInDate'] = [];    
        $new_resident['birthDate']['time'] = $birthDate;
        $new_resident['moveInDate']['time'] = $moveInDate;


        // Example API call
        $data =  $new_resident;
        $data_string = json_encode($data); 

        // set up the curl resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  URL_RESIDENTS );   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));        

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, BASIC_AUTH_USER.":".BASIC_AUTH_PASSWORD);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // execute the request
        $output = curl_exec($ch);       
       
        
        //echo $output;
        // Check for errors
        if($output === FALSE){
            die(curl_error($ch));
            throw new Exception("There was an error");
        }
     
        
        $output = str_replace("\"", "", $output );
        if($output == "OK")
        {
            header("Location: main.php?success=true&opt=resident");
        }
        else
        {
           echo $output;
        }

        
        // close curl resource to free up system resources
        curl_close($ch);

         exit;
     } catch (Exception $th) {
         //throw $th;
         header("Location: error.php");
         exit;
     }
  }


}


?>


<?php
$title_tag = 'Create Resident';
include_once 'shared/top.php';
?>

<h1 class="text-center mt-5">Resident Information <i class="bi bi-person-badge"></i></h1>


<div class="row mt-5 justify-content-center">

    <form novalidate class="col-sm-12  col-md-10 col-lg-9 mb-5"  method="POST">
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="name">Name *</label>
            <div class="col-8">
                <input value='<?= $name ?? ''?>'  required class="<?= (isset($errors['name']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="name">
            
                <p class="text-danger"><?= $errors['name'] ?? ''; ?></p>
            </div>
        </div>
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="firstName">First Name *</label>
            <div class="col-8">
                <input value='<?= $firstName ?? ''?>'  required class="<?= (isset($errors['firstName']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="firstName">
            
                <p class="text-danger"><?= $errors['firstName'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="lastName">Last Name *</label>
            <div class="col-8">
                <input value='<?= $lastName ?? ''?>'  required class="<?= (isset($errors['lastName']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="lastName">
                <p class="text-danger"><?= $errors['lastName'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="preferredName">Preferred Name *</label>
            <div class="col-8">
                <input value='<?= $preferredName ?? ''?>'  required class="<?= (isset($errors['preferredName']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="preferredName">
                <p class="text-danger"><?= $errors['preferredName'] ?? ''; ?></p>
            </div>
        </div>


        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="status">Status</label>
            <div class="col-8">
                <select required name="status" id="" class="<?= (isset($errors['status']) ? 'is-invalid':'') ?>  form-select form-select-lg">
                   <option  value=''>Select...</option>
                   <option <?= isset($status)  && $status == "HERE" ? 'selected':''?>  value='HERE'>Here</option>
                   <option <?= isset($status)  && $status == "Loa" ? 'selected':''?>  value='Loa'>Loa</option> 
                   <option <?= isset($status)  && $status == "Hospital" ? 'selected':''?>  value='Hospital'>Hospital</option>     
                   <option <?= isset($status)  && $status == "ISOLATION" ? 'selected':''?>  value='ISOLATION'>Isolation</option>                     
                </select>
                <p class="text-danger"><?= $errors['status'] ?? ''; ?></p>
            </div>
        </div>


      
        
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="room">Room *</label>
            <div class="col-8">
                <input type="number" value='<?= $room ?? ''?>'  required class="<?= (isset($errors['room']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="room">
                <p class="text-danger"><?= $errors['room'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="levelOfCare">Level Of Care</label>
            <div class="col-8">
                <select required name="levelOfCare" id="" class="<?= (isset($errors['levelOfCare']) ? 'is-invalid':'') ?>  form-select form-select-lg">
                   <option value=''>Select...</option>
                   <option <?= isset($levelOfCare)  && $levelOfCare == "INDEPENDENT" ? 'selected':''?>  value='INDEPENDENT'>INDEPENDENT</option>
                   <option <?= isset($levelOfCare)  && $levelOfCare == "MEMORY" ? 'selected':''?>  value='MEMORY'>MEMORY</option> 
                   <option <?= isset($levelOfCare)  && $levelOfCare == "ASSISTED" ? 'selected':''?>  value='ASSISTED'>ASSISTED</option>     
                   <option <?=  isset($levelOfCare)  && $levelOfCare == "LONGTERM" ? 'selected':''?>  value='LONGTERM'>LONGTERM</option>                     
                </select>
                <p class="text-danger"><?= $errors['levelOfCare'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="ambulation">Ambulation</label>
            <div class="col-8">
                <select required name="ambulation" id="" class="<?= (isset($errors['ambulation']) ? 'is-invalid':'') ?>  form-select form-select-lg">
                   <option  value=''>Select...</option>
                   <option <?= isset($ambulation)  && $ambulation == "CANE" ? 'selected':''?> value='CANE'>CANE</option>
                   <option <?= isset($ambulation)  && $ambulation == "WALKER" ? 'selected':''?>  value='WALKER'>WALKER</option> 
                   <option <?= isset($ambulation)  && $ambulation == "NOLIMITATIONS" ? 'selected':''?>  value='NOLIMITATIONS'>NO LIMITATIONS</option>     
                   <option <?= isset($ambulation)  && $ambulation == "WHEELCHAIR" ? 'selected':''?>  value='WHEELCHAIR'>WHEELCHAIR</option>                     
                </select>
                <p class="text-danger"><?= $errors['ambulation'] ?? ''; ?></p>
            </div>
        </div>
   
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="birthDate">Birth Date *</label>
            <div class="col-8">
                <input type="Date" value='<?= $birthDate ?? ''?>' required class="<?= (isset($errors['birthDate']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="birthDate">
                <p class="text-danger"><?= $errors['birthDate'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="moveInDate">Move in Date *</label>
            <div class="col-8">
                <input type="Date" value='<?= $moveInDate ?? ''?>' required class="<?= (isset($errors['moveInDate']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text" name="moveInDate">
                <p class="text-danger"><?= $errors['moveInDate'] ?? ''; ?></p>
            </div>
        </div>

        <div class="d-grid">
            <button class="btn btn-success btn-lg">Create Account</button>
        </div>
    </form>
</div>

<?php

include_once 'shared/footer.php';

?>