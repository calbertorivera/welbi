<?php 
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function require_login(){

    if(!is_logged_in())
    {
        header('Location:login.php');
        exit;
    }   
}

function validate_resident($new_resident)
{
    $errors = [];

   
    
//check if all imputs are valid
if(empty(trim($new_resident['name'])))
{
    $errors['name'] =  "Please enter a name"."<br>";    
   
}

if(empty(trim($new_resident['firstName'])))
{
    $errors['firstName'] =  "Please enter a first name"."<br>";    
   
}
if(empty(trim($new_resident['lastName'])))
{
    $errors['lastName'] =  "Please enter a last name"."<br>";    
   
}
if(empty(trim($new_resident['preferredName'])))
{
    $errors['preferredName'] =  "Please enter a preferred name"."<br>";    
   
}

if(empty(trim($new_resident['room'])))
{
    $errors['room'] =  "Please enter a room"."<br>";    
   
}
if(empty(trim($new_resident['birthDate'])))
{
    $errors['birthDate'] =  "Please enter a birth date"."<br>";    
   
}
else
{
    if(!validate_date($new_resident['birthDate']))
    {
        $errors['birthDate'] =  "Please enter a valid birth date"."<br>";    
    }
}

if(empty(trim($new_resident['moveInDate'])))
{
    $errors['moveInDate'] =  "Please enter a move in date"."<br>";    
   
}
else
{
    if(!validate_date($new_resident['moveInDate']))
    {
        $errors['moveInDate'] =  "Please enter a valid move in date"."<br>";    
    }
}


return $errors;

}

function validate_date($date, $format = 'Y-m-d')
{   
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validate_program($new_program)
{ 
    $errors = [];


    if(empty(trim($new_program['name'])))
    {
        $errors['name'] =  "Please enter a name"."<br>";    
       
    }
    
    if(empty(trim($new_program['location'])))
    {
        $errors['location'] =  "Please enter a location"."<br>";    
       
    }    

    if(empty($new_program['hobbies']))
    {
        $errors['hobbies'] =  "Please set at least one hobbie"."<br>";    
       
    }   

    if(empty($new_program['dimension']))
    {
        $errors['dimension'] =   "Please enter the dimension"."<br>";    
       
    }   

    if(empty($new_program['levelOfCare']))
    {
        $errors['levelOfCare'] =  "Please select a level of care"."<br>";    
       
    }    
    
   
    if(empty(trim($new_program['start'])))
    {
        $errors['start'] =  "Please enter a start date"."<br>";    
       
    }
    else
    {
        if(!validate_date($new_program['start']))
        {
            $errors['start'] =  "Please enter an end date"."<br>";    
        }
    }

    if(empty(trim($new_program['end'])))
    {
        $errors['end'] =  "Please enter a start date"."<br>";    
       
    }
    else
    {
        if(!validate_date($new_program['end']))
        {
            $errors['end'] =  "Please enter an end date"."<br>";    
        }
    }

    if(!empty(trim($new_program['end'])) && !empty(trim($new_program['start'])))
    {
        if(validate_date($new_program['start']) && validate_date($new_program['end']))
        {
            $format = 'Y-m-d';
           
            if(DateTime::createFromFormat($format, $new_program['start']) > DateTime::createFromFormat($format, $new_program['end']))
            {
                $errors['start'] =  "Start date can not be later than end date."."<br>";  
            }

        }

    }

    return $errors;

}


?>