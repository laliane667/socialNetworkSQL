<?php
    include_once 'header.php';
?>

<div>
    <form action="includes/upload.inc.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit" name="submitPP">Upload file</button>
    </form>

    <form action="includes/delete.inc.php" method="POST">
        <button type="submit" name="deletePP">Delete file</button>
    </form>

    <?php
        require_once 'includes/dbh.inc.php';    
        require_once 'includes/function.inc.php';   
        require_once 'display.php'; 
        $userId = $_SESSION["userid"];
        $userUid = $_SESSION["useruid"];

        $PPData = getPPData($conn, $userId);
        $status = $PPData['status'];
        $formatProfilPic = $PPData['imgExt']; 

        echo "<div>";
        if($status == 0){
            echo "<img src='uploads/profileImg/profileDefault.jpg'>";
        }else if($status == 1) {
            echo "<img src='uploads/profileImg/profile".$userId.".".$formatProfilPic."'>";
        }
        echo "</div>"; 
        echo "<h2>Username: ".$userUid."</h2>";

        displayFollowings($conn,$userId);
        displayFollowers($conn,$userId);
        displayPosts($conn,$userId);
    ?>
</div>

<?php
    include_once 'footer.php';
?>