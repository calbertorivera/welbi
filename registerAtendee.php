<?php


session_start();
require_once 'validations.php';
require_login();

//SERVER PARAMETERS
require_once 'backend_cred.php';



$atendee= [];

$atendee["programId"]=$_GET["programId"];
$atendee["attendeeId"]=$_GET["attendeeId"];
$atendee["status"] = $_GET["status"];

// Example API call
$data =  $atendee;
$data_string = json_encode($data); 

// set up the curl resource
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,  URL_REGISTER_ATTENDEE );   
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


   // get program
    
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, URL_PROGRAMS.'/'. $atendee["programId"]);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   curl_setopt($ch, CURLOPT_USERPWD, BASIC_AUTH_USER.":".BASIC_AUTH_PASSWORD);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

   $programs = curl_exec($ch);
   curl_close($ch);  
   $json = json_decode($programs , true);

   require_once 'attendeesTable.php';

?>