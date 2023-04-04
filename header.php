<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laliane667</title>

    <script src="https://kit.fontawesome.com/5c4b16e6c8.js" crossorigin="anonymous"></script>

    <!-- IMPORTING NEW FONT FROM: <https://fonts.google.com/> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;700&family=Roboto:wght@100;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                

                <?php
                    if(isset($_SESSION["useruid"])){
                        echo "<li class='navbar__item'><a href='/' class='navbar__links'>Home</a></li>";
                        echo "<li class='navbar__item'><a href='new-post.php' class='navbar__links'>Post</a></li>";
                        echo "<li class='navbar__btn'><a href='profil.php' class='button'>Profil</a></li>";
                        echo "<li class='navbar__btn'><a href='includes/logout.inc.php' class='button'>Log&nbsp;out</a></li>";
                    }
                    else
                    {
                        echo "<li class='navbar__btn'><a href='signup.php' class='button'>Sign&nbsp;up</a></li>";
                        echo "<li class='navbar__btn'><a href='login.php' class='button'>Log&nbsp;in</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>