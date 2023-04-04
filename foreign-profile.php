<?php
    include_once 'header.php';
?>

<div>
    <?php
        require_once 'includes/dbh.inc.php';
        require_once 'includes/function.inc.php'; 
        require_once 'display.php'; 
        session_start();   

        $userUid = mysqli_real_escape_string($conn, $_GET['usersuid']);

        if($userUid == $_SESSION['useruid']){
            header("location: ../profil.php");
            exit();
        }

        $sql = "SELECT * FROM users WHERE usersUid='$userUid';";
        $result = mysqli_query($conn, $sql);
        $queryResults = mysqli_num_rows($result);

        if($queryResults > 0){
            while($rows = mysqli_fetch_assoc($result)){
                $userId = $rows['usersId'];

                echo "<div><h3>".$rows['usersUid']."</h3></div>";
                if(isAFollowedByB($conn, $userId, $_SESSION['userid']) === false){
                    echo 
                    "<form action='includes/follow.inc.php?usersuid=".$rows['usersUid']."' method='POST'>
                        <button name='follow'>Follow</button>
                    </form>";
                }
                else{
                    echo 
                    "<form action='includes/unfollow.inc.php?usersuid=".$rows['usersUid']."' method='POST'>
                        <button name='follow'>Unfollow</button>
                    </form>";
                }
                
                
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

                displayPosts($conn,$userId);

            }
        }
    ?>
</div>

<?php
    include_once 'footer.php';
?>