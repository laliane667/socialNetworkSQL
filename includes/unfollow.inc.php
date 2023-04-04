<?php

require_once 'dbh.inc.php';
require_once 'function.inc.php';
session_start();

$followedUid = mysqli_real_escape_string($conn, $_GET['usersuid']);
$follower = $_SESSION["userid"];

$uidexists = uidExists($conn, $followedUid, $followedUid);
if($uidexists === false){
    header("location: ../foreign-profile.php?usersuid=".$followedUid."?error=invaliduser");
    exit();
}
if(isset($_POST['follow'])){
    
    /* PENSER A CHECKER QUE LES 2 IDS SOIENT DIFFERENTS */
    if(deleteRelation($conn, $follower, $uidexists["usersId"]) === false){
        header("location: ../foreign-profile.php?usersuid=".$followedUid."?error=relationinvalid");
        exit();
    }
    else{
        header("location: ../foreign-profile.php?usersuid=".$followedUid);
        exit();
    }
}
else{
    if(empty($followedUid)){
        header("location: ../");
        exit();
    }else{
        header("location: ../foreign-profile.php?usersuid=".$followedUid);
        exit();
    }
} 