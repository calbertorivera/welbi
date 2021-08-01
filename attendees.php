<?php 



session_start();
require_once 'validations.php';


//connect to the database
require_once 'database.php';
$conn = db_connect();


//title page
$title_tag = 'Programs List';
include_once 'shared/top.php';


//SERVER PARAMETERS
require_once 'backend_cred.php';

//if the request is a get method
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["program_id"]))
{    
    // get program through the web service
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL_PROGRAMS.'/'. $_GET["program_id"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, BASIC_AUTH_USER.":".BASIC_AUTH_PASSWORD);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $programs = curl_exec($ch);
    curl_close($ch);  
    $json = json_decode($programs , true);


    //Gets the residents to populate the dropdown list
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URL_RESIDENTS);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, BASIC_AUTH_USER.":".BASIC_AUTH_PASSWORD);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $programs = curl_exec($ch);
    curl_close($ch);  

    //encode the answer
    $json_residents = json_decode($programs , true);

   
}
?>
<!-- scripts for icons -->
<link rel="stylesheet" href="css/programdetails.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
    integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />


<div class="container">

    <ul class="list-style9 no-margin">
        <li></li>
        <li>
            <div class="row">
                <h1>Program Details</h1>
            </div>
        </li>
        <li></li>
    </ul>


    <div class="team-single">
        <div class="row">
            <div class="mb-5 col-lg-5 col-md-5 xs-margin-30px-bottom">
                <div class="team-single-img  d-none d-sm-block">

                    <img src="img/program.jpg" alt="">
                </div>
                <div class="bg-light-gray padding-30px-all md-padding-25px-all sm-padding-20px-all text-center">
                    <h4 class="margin-10px-bottom font-size24 md-font-size22 sm-font-size20 font-weight-600">
                        <?= $json["name"] ?></h4>
                    <h5 class="margin-6px-bottom font-size14 md-font-size14 sm-font-size14 font-weight-400">
                        (ID#:<?= $json["id"] ?>) </h5>
                    <p class="sm-width-95 sm-margin-auto">The <?= $json["name"] ?> program take place in
                        <?=$json["start"] ?> at <?= $json["location"] ?> <?= $json["allDay"] ? "all day.":""  ?></p>

                    <ul class="list-style9 no-margin mt-5">
                        <li>

                            <div class="row">
                                <div class="col-md-5 col-5">
                                    <i class="bi bi-upc "></i>
                                    <strong class="margin-10px-left ">Name:</strong>
                                </div>
                                <div class="col-md-7 col-7">
                                    <p><?= $json["name"] ?></p>
                                </div>
                            </div>

                        </li>
                        <li>

                            <div class="row">
                                <div class="col-md-5 col-5">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <strong class="margin-10px-left ">Location:</strong>
                                </div>
                                <div class="col-md-7 col-7">
                                    <p> <?= $json["location"] ?></p>
                                </div>
                            </div>

                        </li>
                        <li>

                            <div class="row">
                                <div class="col-md-5 col-5">
                                    <i class="bi bi-cloud-sun "></i>
                                    <strong class="margin-10px-left ">All day?:</strong>
                                </div>
                                <div class="col-md-7 col-7">
                                    <p> <?= $json["allDay"] ? "Yes":"No"  ?></p>
                                </div>
                            </div>

                        </li>

                        <li>

                            <div class="row">
                                <div class="col-md-5 col-5">
                                    <i class="bi bi-calendar3 "></i>
                                    <strong class="margin-10px-left ">Start:</strong>
                                </div>
                                <div class="col-md-7 col-7">
                                    <p> <?= $json["start"] ?></p>
                                </div>
                            </div>

                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-5 col-5">
                                    <i class="bi bi-calendar3 "></i>
                                    <strong class="margin-10px-left ">End:</strong>
                                </div>
                                <div class="col-md-7 col-7">
                                    <p> <?= $json["end"] ?></p>
                                </div>
                            </div>
                        </li>

                        <?php if($json["tagsSplitted"] != '' ) { ?>
                        <li>
                            <div class="row">
                                <div class="col-md-5 col-5">
                                    <i class="bi bi-twitter  "></i>
                                    <strong class="margin-10px-left">Tags:</strong>
                                </div>
                                <div class="col-md-7 col-7">
                                    <p> <?= $json["tagsSplitted"] ?></p>
                                </div>
                            </div>
                        </li>

                        <?php } ?>
                    </ul>
                    <div class="margin-20px-top team-single-icons">
                        <ul class="no-margin">
                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-7">
                <?php require_once 'attendeesTable.php'; ?>
                <?php  
                            if(is_logged_in())
                            {                            
                            ?>
                <div class="row">
                    <div class="col-md-8 col-6">
                        <label for="attendeesDataList" class="form-label">Add Attendee:</label>
                        <input class="form-control" list="datalistOptions" id="attendeesDataList"
                            placeholder="Type to search...">
                        <datalist id="datalistOptions">
                            <?php foreach($json_residents as $resident) 
                        {
                            if(strpos($resident["name"], '[') === false){ ?>
                            <option programId="<?= $json["id"] ?>" attendeeId="<?= $resident["id"] ?>"
                                value="<?= $resident["name"] ?>">
                                <?php } } ?>
                        </datalist>
                        <br>
                    </div>
                    <div class="col-md-4 col-6">
                        <label class="form-label" for="gender">Program Status</label>

                        <select required name="gender" id="status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Passive">Passive</option>
                            <option value="Declined">Declined</option>
                            <option value="Undefined">Undefined</option>
                        </select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <a class="btn btn-success " id="addAttendee">Add attendee</a>
                    </div>
                </div>
                <?php  
                           }                          
                            ?>
            </div>
        </div>
     
    </div>



</div>
</div>
</div>

<script>
$(document).ready(function() {
    $('#addAttendee').click(function() {

        var val = $("#attendeesDataList").val();

        var obj = $("#datalistOptions").find("option[value='" + val + "']");


        if (obj != null && obj.length > 0) {
            $(".se-pre-con").show();
            $.get("registerAtendee.php?status=" + $("#status").val() +
                "&programId=<?= $json["id"] ?>&attendeeId=" + $(obj).attr(
                    'attendeeId'),
                function(data) {

                    $("#ContainerAttendees").html(data);
                    $(".se-pre-con").fadeOut("slow");;

                });

        } else {
            alert("Please select an attendee from the list"); // don't allow form submission
        }
    });
});
</script>

<?php 

include_once 'shared/footer.php';

?>