<?php

session_start();
require_once 'dbh.inc.php';
$userId = $_SESSION["userid"];

if(isset($_POST['submitPP'])){

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');
    $maxSize = 1000000;

    /* Pense a checker the mime type == image */

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < $maxSize){
                $fileNewName = "profile".$userId.".".$fileActualExt;
                $fileDestination = '../uploads/profileImg/'.$fileNewName;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE usersProfilPic SET status=1 WHERE userid='$userId';";
                $result = mysqli_query($conn, $sql); 
                $sql = "UPDATE usersProfilPic SET imgExt='$fileActualExt' WHERE userid='$userId';";
                $result = mysqli_query($conn, $sql); 

                header("location: ../profil.php?error=none");
                exit();
            }
            else{
                header("location: ../profil.php?error=toobigfile");
                exit(); 
            }
        }
        else{
            header("location: ../profil.php?error=uploadfailed");
            exit(); 
        }
    }
    else{
        header("location: ../profil.php?error=formatnotallowed");
        exit();
    }
    
}
else if(isset($_POST['submit'])){
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');
    $maxSize = 1000000;

    /* Pense a checker the mime type == image */

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < $maxSize){
                $fileNewName = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNewName;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("location: ../profil.php?error=none");
                exit();
            }
            else{
                header("location: ../profil.php?error=toobigfile");
                exit(); 
            }
        }
        else{
            header("location: ../profil.php?error=uploadfailed");
            exit(); 
        }
    }
    else{
        header("location: ../profil.php?error=formatnotallowed");
        exit();
    }
}
else{
    header("location: ../profil.php");
    exit();
}