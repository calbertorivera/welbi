<?php 
$levelOfCare_options =['INDEPENDENT','ASSISTED','MEMORY','LONGTERM'];

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
    $levelOfCare = [];
   
    
    if(isset($_POST["levelOfCare"]))   
    {
       
        $levelOfCare = $_POST["levelOfCare"] ;
    }

    $name =  trim(filter_var($_POST["name"], FILTER_SANITIZE_STRING));
    $location = trim(filter_var($_POST["location"], FILTER_SANITIZE_STRING));
    $allDay  = trim(filter_var($_POST["allDay"], FILTER_SANITIZE_STRING));
    $start = trim(filter_var($_POST["start"], FILTER_SANITIZE_STRING));
    $end      = trim(filter_var($_POST["end"], FILTER_SANITIZE_STRING));
    $isRepeated = trim(filter_var($_POST["isRepeated"], FILTER_SANITIZE_STRING));
    $tags      = trim(filter_var($_POST["tags"]));
    $hobbies = trim(filter_var($_POST["hobbies"]));
    $facilitators = trim(filter_var($_POST["facilitators"]));
    $dimension = trim(filter_var($_POST["dimension"]));
    
     // create an associative array on the user inmput
    $new_program =[];
    $new_program['name'] = $name;
    $new_program['location'] = $location;
    $new_program['allDay'] = $allDay;
    $new_program['start'] = $start;
    $new_program['end'] = $end;
    $new_program['tags'] = $tags;
    $new_program['hobbies'] = $hobbies;
    $new_program['facilitators'] = $facilitators;
    $new_program['isRepeated'] = $isRepeated;
    $new_program['levelOfCare'] =  $levelOfCare;
    $new_program['dimension'] = $dimension;

     // validate the inputs
     $errors = validate_program($new_program);

  //if there are no errors, insert into db
  if(empty($errors))
  {

     try
     {

        // Example API call
        $data =  $new_program;
        $data_string = json_encode($data); 

        // set up the curl resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  URL_PROGRAMS );   
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
            header("Location: main.php?success=true&opt=program");
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

<h1 class="text-center mt-5">Program Information <i class="bi bi-calendar2-check"></i></h1>


<div class="row mt-5 justify-content-center">

    <form class="col-sm-12  col-md-10 col-lg-9 mb-5" method="POST">
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="name">Name *</label>
            <div class="col-8">
                <input required value='<?= $name ?? ''?>' required
                    class="<?= (isset($errors['name']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text"
                    name="name">

                <p class="text-danger"><?= $errors['name'] ?? ''; ?></p>
            </div>
        </div>
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="location">Location *</label>
            <div class="col-8">
                <input required value='<?= $location ?? ''?>' required
                    class="<?= (isset($errors['location']) ? 'is-invalid':'') ?> form-control form-control-lg"
                    type="text" name="location">

                <p class="text-danger"><?= $errors['location'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="allDay">Is all day? *</label>
            <div class="col-8">
                <input type="radio" class="form-check-input fs-4" required
                    <?= isset($allDay)  && $allDay == "true" ? 'checked':''?> value="true" name="allDay" checked>
                <label class="form-check-label fs-4" for="allDay">
                     Yes &nbsp; &nbsp;
                </label></input>
                <input class="form-check-input fs-4" type="radio" <?= isset($allDay)  && $allDay == "false" ? 'checked':''?>
                    name="allDay">
                <label class="form-check-label fs-4" for="allDay">
                No
                </label></input>
                
            </div>
        </div>


        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="isRepeated">Is repeated? *</label>
            <div class="col-8">
                <input type="radio" class="form-check-input fs-4" 
                    <?= isset($isRepeated)  && $isRepeated == "true" ? 'checked':''?> value="true" name="isRepeated" checked>
                <label class="form-check-label fs-4" for="isRepeated">
                    Yes &nbsp; &nbsp;
                </label></input>
                <input class="form-check-input fs-4" required type="radio" <?= !isset($isRepeated) || (isset($isRepeated) && $isRepeated == "false") ? 'checked':''?>
                    name="isRepeated" value="false">
                <label class="form-check-label fs-4" for="allisRepeatedDay">
                 No
                </label></input>
            </div>
        </div>



        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="hobbies">Hobbies *</label>
            <div class="col-8">
                <div class="form-group">
                <input class="form-control form-control-lg" type="text" id="hobbies" class="tagged form-control" data-removeBtn="true"
                 name="hobbies" value='<?= $hobbies ?? ''?>' placeholder="Add multiple hobbies by pressing Enter key.">
                   
                </div>
                <p class="text-danger"><?= $errors['hobbies'] ?? ''; ?></p>
            </div>
           
        </div>

        
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="facilitators">Facilitators *</label>
            <div class="col-8">
                <div class="form-group">
                <input class="form-control form-control-lg" type="text" id="facilitators" class="tagged form-control" data-removeBtn="true"
                 name="facilitators" value='<?= $facilitators ?? ''?>' placeholder="Add multiple facilitators by pressing Enter key.">
                   
                </div>
                <p class="text-danger"><?= $errors['facilitators'] ?? ''; ?></p>
            </div>
           
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="levelOfCare">Level Of Care *</label>
            <div class="col-8">
            <fieldset>

                <?php  
                
                foreach ($levelOfCare_options as $key => $lc) {
                    
                    $selected = false;
                    if(isset($levelOfCare))
                    {
                        foreach ($levelOfCare as $key => $lc_selected) 
                        {
                            if($lc == $lc_selected)
                            {
                                $selected =true;
                            }
                        }

                    }                   
                    ?>
                    <div>
                    <input class="<?= (isset($errors['levelOfCare']) ? 'is-invalid':'') ?> form-check-input fs-4" type="checkbox" value='<?= $lc?>' <?= $selected ? "checked":"" ?> name="levelOfCare[]">
                    <label class="form-check-label fs-4" for="levelOfCare"><?= ucwords(strtolower($lc))?> </label></div>
              
                <?php   } ?>
                </fieldset>
                 
                <p class="text-danger"><?= $errors['levelOfCare'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="dimension">Dimension *</label>
            <div class="col-8">
                <input required value='<?= $dimension ?? ''?>' required
                    class="<?= (isset($errors['dimension']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text"
                    name="dimension">

                <p class="text-danger"><?= $errors['dimension'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="start">Start Date *</label>
            <div class="col-8">
                <input required type="Date" value='<?= $start ?? ''?>' required
                    class="<?= (isset($errors['start']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text"
                    name="start" value='<?= $start ?? ''?>'>
                <p class="text-danger"><?= $errors['start'] ?? ''; ?></p>
                
            </div>
        </div>
        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="end">End Date *</label>
            <div class="col-8">
                <input required type="Date" value='<?= $end ?? ''?>' required
                    class="<?= (isset($errors['end']) ? 'is-invalid':'') ?> form-control form-control-lg" type="text"
                    name="end" value='<?= $end ?? ''?>'>
                <p class="text-danger"><?= $errors['end'] ?? ''; ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <label class="col-4 col-form-label fs-4" for="tags">Tags</label>
            <div class="col-8">
                <div class="form-group">
                <input class="form-control form-control-lg" type="text" id="tags" class="tagged form-control" data-removeBtn="true"
                 name="tags" value='<?= $tags ?? ''?>' placeholder="Add multiple tags by pressing Enter key.">
                   
                </div>
                <p class="text-danger"><?= $errors['tags'] ?? ''; ?></p>

            </div>
        </div>


        <div class="d-grid">
            <button class="btn btn-success btn-lg">Create Account</button>
        </div>
    </form>
</div>


<script>
$(document).ready(function(){

    $('#tags').tagsInput({
   'height':'200px',
   'width':'100%',
   'interactive':true,
   'defaultText':'Enter to add more.',
   'delimiter': ',',   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : false,
   'minChars' : 0,
   'maxChars' : 0, // if not provided there is no limit
   'placeholderColor' : '#666666'
});

$('#hobbies').tagsInput({
   'height':'200px',
   'width':'100%',
   'interactive':true,
   'defaultText':'Enter to add more.',
   'delimiter': ',',   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : false,
   'minChars' : 0,
   'maxChars' : 0, // if not provided there is no limit
   'placeholderColor' : '#666666'
});

$('#facilitators').tagsInput({
   'height':'200px',
   'width':'100%',
   'interactive':true,
   'defaultText':'Enter to add more.',
   'delimiter': ',',   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : false,
   'minChars' : 0,
   'maxChars' : 0, // if not provided there is no limit
   'placeholderColor' : '#666666'
});




});

</script>
<?php

include_once 'shared/footer.php';

?>