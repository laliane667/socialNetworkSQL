<?php
    include_once 'header.php';
?>

<?php
    if(isset($_POST['submit-search'])){

        if (empty($_POST['search'])){
            header("location: ../?error=inputfieldempty");
            exit(); 
        }
        require_once 'includes/dbh.inc.php';
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        $username = $_SESSION['useruid'];
        $sql = "SELECT * FROM users WHERE usersUid!='$username' AND usersUid LIKE '%$search%';";
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);

        if($queryResult > 0){
            echo $queryResult." result(s) found.";
            while($rows = mysqli_fetch_assoc($result)){
                echo "<a href='foreign-profile.php?usersuid=".$rows['usersUid']."'><div><h3>".$rows['usersUid']."</h3></div></a>";
            } 
        }else{
            header("location: ../?error=noresult");
            exit(); 
        }

    }else{
        header("location: ../");
        exit();
    }
?>

<?php
    include_once 'footer.php';
?>