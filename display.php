<?php

function displayFollowings($conn,$userId){
    $sql = "SELECT rel_followed FROM relation WHERE rel_follower='$userId';";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);

    echo "<br>";
    echo "You have ".$queryResults." following(s).";
    if($queryResults > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $id = $rows['rel_followed'];
            $username = getUsernameByID($conn, $id);
            echo "<a href='foreign-profile.php?usersuid=".$username['usersUid']."'><div><h3>".$username['usersUid']."</h3></div></a>";
        }
    }
}

function displayFollowers($conn,$userId){
    $sql = "SELECT rel_follower FROM relation WHERE rel_followed='$userId';";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);
    
    echo "<br>";
    echo "You have ".$queryResults." follower(s).";
    if($queryResults > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $id = $rows['rel_follower'];
            $username = getUsernameByID($conn, $id);
            echo "<a href='foreign-profile.php?usersuid=".$username['usersUid']."'><div><h3>".$username['usersUid']."</h3></div></a>";
        }
    }
}

function displayPosts($conn,$userId){
    $sql = "SELECT * FROM posts WHERE p_author='$userId';";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);

    if($queryResults > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $id = $rows['p_id'];
            $date = $rows['p_date'];
            $tag = $rows['p_tag'];
            $maxloc = $rows['p_maxloc'];
            echo "<hr>";
            echo "<div><h3>".$tag."</h3></div>";
            
            for($indice = 0; $indice < $maxloc; $indice++){
                displayArticle($conn, $id, $indice);
                displayIllustration($conn, $id, $userId, $indice);
            }

            echo "<br>";

            echo "<div>Made the: ".$date."</div>";
            echo "<hr>";
        }
    }
}

function displayArticle($conn, $id, $location){
    $sql = "SELECT pa_text FROM posts_article WHERE pa_postId='$id' AND pa_location='$location';";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);

    if($queryResults > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $textnotformated = $rows['pa_text'];
            $text = htmlentities($textnotformated);
            echo "<br>";
            echo "<div><p>".$text."</p></div>";
        }
    }
}

function displayIllustration($conn, $id, $userId, $location){
    $sql = "SELECT * FROM posts_illustration WHERE pi_postId='$id' AND pi_location='$location';";
    $result = mysqli_query($conn, $sql);
    $queryResults = mysqli_num_rows($result);

    if($queryResults > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $file = $rows['pi_fileName'];
            $ext = $rows['pi_fileExtension'];

            echo "<br>";
            echo "<div>";
            if($ext === "mp4"){
                echo "<video controls='controls' style='width: 400px;'><source src='uploads/posts/".$file.".".$ext."' type='video/mp4'></video>";
            }
            else{
                echo "<img style='width: 400px;' src='uploads/posts/".$file.".".$ext."'>";
            }
            echo "</div>"; 
        }
    }
}
