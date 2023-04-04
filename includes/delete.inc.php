<?php

if(isset($_POST['deletePP'])){

    session_start();
    require_once 'dbh.inc.php';
    require_once 'function.inc.php'; 
    $userId = $_SESSION["userid"];
    $PPData = getPPData($conn, $userId);
    /* $status = $PPData['status']; */
    $formatProfilPic = $PPData['imgExt']; 
    $fileName = "../uploads/profileImg/profile".$userId.".".$formatProfilPic;
    if(!unlink($fileName)){
        header("location: ../profil.php?error=filenotfound");
        exit();
    }
    else{
        $sql = "UPDATE usersProfilPic SET status=0 WHERE userid='$userId';";
        mysqli_query($conn, $sql);
        header("location: ../profil.php?error=none");
        exit();
    }
    
}
else{
    header("location: ../profil.php");
    exit();
}