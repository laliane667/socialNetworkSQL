<?php

require_once 'dbh.inc.php'; 
require_once 'function.inc.php'; 
session_start();

$author = $_SESSION["userid"];

if(isset($_POST["submit-post"])){

    $targetNbIpt = $_POST['targetNbIpt'];
    $tag = $_POST["tag"];
    $dateTime = date("Y-m-d h:i:s");

    //CHECKING EMPTY INPUTS
    if(empty($tag)){
        header("location: ../new-post.php?error=emptytag");
        exit();
    } 

    for($i = 0; $i < $targetNbIpt; $i++){
        if(empty($_POST['npIpt-'.$i]) && empty($_FILES['npIpt-'.$i])){
            header("location: ../new-post.php?error=emptyinput");
            exit();
        }
        else if(!empty($_FILES['npIpt-'.$i])){
            
            $fileName = $_FILES['npIpt-'.$i]['name'];
            $fileSize = $_FILES['npIpt-'.$i]['size'];
            $fileError = $_FILES['npIpt-'.$i]['error'];

            $fileExt = explode('.',$fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'mp4');
            $maxSize = 1000000000;

            /* Pense a checker the mime type == image */

            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0){
                    if($fileSize > $maxSize){
                        header("location: ../new-post.php?error=file".$i."-istoobig");
                        exit();
                    }
                }
                else{
                    header("location: ../new-post.php?error=file".$i."-uploadfailed");
                    exit(); 
                }
            }
            else{
                header("location: ../new-post.php?error=file".$i."-formatnotallowed");
                exit();
            }
        }
    }  

    $conter = 0;
    if(createPost($conn, $author, $dateTime, $tag, $targetNbIpt) !== true){
        header("location: ../new-post.php?error=stmtfailed");
        exit();
    }
    $postId = getPostId($conn, $author, $dateTime);
    while(!empty($_POST['npIpt-'.$conter]) || !empty($_FILES['npIpt-'.$conter])){
        
        if(!empty($data = $_POST['npIpt-'.$conter])){
            if(createPostArticle($conn, $author, $dateTime, $data, $conter) !== true){
                header("location: ../new-post.php?error=problem_while_creating_article");
                exit();
            }
        }
        else if(!empty($data = $_FILES['npIpt-'.$conter])){
            $fileName = $_FILES['npIpt-'.$conter]['name'];
            $fileTmpName = $_FILES['npIpt-'.$conter]['tmp_name'];

            $fileExt = explode('.',$fileName);
            $fileActualExt = strtolower(end($fileExt));

            $fileNewName = "user".$author."post".$postId."location".$conter;
            $fileDestination = '../uploads/posts/'.$fileNewName.'.'.$fileActualExt;
            if(createPostIllustration($conn, $author, $dateTime, $fileNewName, $fileActualExt, $conter) !== true){
                header("location: ../new-post.php?error=problem_while_uploading_illustration");
                exit();
            }
            move_uploaded_file($fileTmpName, $fileDestination); 
        }
        $conter = $conter +1;
    }
    
    header("location: ../index.php?error=none");
    exit();
}
else{
    header("location: ../new-post.php");
    exit();
}