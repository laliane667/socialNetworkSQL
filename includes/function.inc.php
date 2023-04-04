<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
    $result;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}


function invalidUid($username){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){
    $result;
    if($pwd !== $pwdRepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email){
   
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd){
   
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    $sql = "SELECT * FROM users WHERE usersUid='$username' AND usersEmail='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['usersId'];
        }
    }else{
        header("location: ../signup.php?error=problem");
        exit();
    }
    
    $status = 0;
    $imgExt = "undefined";

    $sql_ = "INSERT INTO usersProfilPic (userid, status, imgExt) VALUES (?, ?, ?);";
    $stmt_ = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt_, $sql_))
    {
        header("location: ../signup.php?error=stmt_failed");
        exit();
    }

    mysqli_stmt_bind_param($stmt_, "sss", $id, $status, $imgExt);
    mysqli_stmt_execute($stmt_);
    mysqli_stmt_close($stmt_);

    header("location: ../signup.php?error=none");
    exit();
}


function emptyInputLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false)
    {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkedPwd = password_verify($pwd, $pwdHashed);

    if($checkedPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }else if($checkedPwd === true)
    {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        
        header("location: ../index.php");
        exit(); 
    }
}


function getPPData($conn, $userId){
    $sql = "SELECT * FROM usersProfilPic WHERE userid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createRelation($conn, $follower, $followed, $dateTime){

    $sql = "INSERT INTO relation (rel_follower, rel_followed, rel_date) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
       return false;
    }

    mysqli_stmt_bind_param($stmt, "sss", $follower, $followed, $dateTime);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return true;
}

function deleteRelation($conn, $follower, $followed){
    $sql = "DELETE FROM relation WHERE rel_follower='$follower' AND rel_followed='$followed'";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        return false;
    }

    return true;
}

function isAFollowedByB($conn, $A, $B){
    $sql = "SELECT * FROM relation WHERE rel_follower='$B' AND rel_followed='$A';";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);

    if($queryResults > 0){
        return true;
    }else{
        return false;
    }
}

function getUsernameByID($conn, $id){
    
    $sql = "SELECT * FROM users WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../profil.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        mysqli_stmt_close($stmt);
        return $row;
    }else{
        $result = false;
        return $result;
    }
} 

function createPost($conn, $author, $dateTime, $tag, $maxloc){
    $sql = "INSERT INTO posts (p_author, p_date, p_tag, p_maxloc) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ssss", $author, $dateTime, $tag, $maxloc);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

function getPostId($conn, $author, $dateTime){
    $sql = "SELECT * FROM posts WHERE p_author='$author' AND p_date='$dateTime'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['p_id'];
        }
    }else{
        return false;
    }
    return $id;
}

function createPostArticle($conn, $author, $dateTime, $article, $location){
    $sql = "SELECT * FROM posts WHERE p_author='$author' AND p_date='$dateTime'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['p_id'];
        }
    }else{
        return false;
    }

    $sql = "INSERT INTO posts_article (pa_postId, pa_location, pa_text) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sss", $id, $location, $article);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

function createPostIllustration($conn, $author, $dateTime, $fileNewName, $fileActualExt, $location){

    $sql = "SELECT * FROM posts WHERE p_author='$author' AND p_date='$dateTime'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['p_id'];
        }
    }else{
        return false;
    }

    $sql = "INSERT INTO posts_illustration (pi_postId, pi_location, pi_fileName, pi_fileExtension) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ssss", $id, $location, $fileNewName, $fileActualExt);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;

}