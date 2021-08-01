<!DOCTYPE html>
<html lang="en">

<head>

    <!-- common styles and scripts for all tables -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_tag ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Creepster&family=Poiret+One&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/tagsInput.css">    
    <script src="scripts/tagsInput.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon//favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
</head>

<body>
<div class="se-pre-con" style="display:none"></div>
    <div class="container">
    <?php   if(isset($_GET["success"]) && isset($_GET["opt"]) && $_GET["opt"] == 'resident' ) {  ?>
        <div class="alert alert-success" role="alert">
        The resident has been successfully created.
        </div>
    <?php }  else if(isset($_GET["success"]) && isset($_GET["opt"]) && $_GET["opt"] == 'program' ) {  ?>
        <div class="alert alert-success" role="alert">
        The program has been successfully created.
        </div>
    <?php }  ?>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand gamefont fs-4" href="#"><img class="logo" src='img/logo.png'></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="main.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="programs.php">Programs</a>
                            </li>
                            <?php  
                            if(is_logged_in())
                            {                            
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="resident.php">Create Resident</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="program.php">Create Program</a>
                            </li>
                            <?php  
                            }                      
                            ?>
                        </ul>
                        <ul class="navbar-nav d-flex">
                            <?php  
                            if(is_logged_in())
                            {                            
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> <?= $_SESSION['username']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="logout.php">Logout <i
                                                class="bi bi-box-arrow-right"></i></a></li>

                                </ul>
                            </li>
                            <?php  
                            }  else {                    
                            ?>

                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="Register.php">Register</a>
                            </li>

                            <?php  
                            }                
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>