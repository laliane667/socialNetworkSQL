<?php
    include_once 'header.php';
?>


<div id="main_introduction">
    <h1>Welcome on laliane667</h1>
    <form action="search.php" method="POST">
        <input type="text" name="search" placeholder="Search"> 
        <button type="submit" name="submit-search">Search</button>
    </form>
    

    <!-- <div class="container">
        <div class="row">
            <h2>Search Here</h2>
            <input type="text" name="term" id="term" placeholder="search here...." class="form-control">  
        </div>
    </div>
<script type="text/javascript">
  $(function() {
     $( "#term" ).autocomplete({
       source: 'ajax-db-search.php',
     });
  }); -->
</script>


</div>

<div class="user_list">
    <?php
        /* require_once 'includes/dbh.inc.php';
        $sql = "SELECT * FROM users;";
        $result = mysqli_query($conn, $sql);
        $queryResults = mysqli_num_rows($result);

        if($queryResults > 0){
            while($rows = mysqli_fetch_assoc($result)){
                echo "<div><h3>".$rows['usersUid']."</h3></div>";
            }
        } */

        require_once 'includes/dbh.inc.php';
        require_once 'includes/function.inc.php';
        require_once 'display.php';
        $sql = "SELECT * FROM users;";
        $result = mysqli_query($conn, $sql);
        $queryResults = mysqli_num_rows($result);

        if($queryResults > 0){
            while($rows = mysqli_fetch_assoc($result)){
                if(isAFollowedByB($conn, $rows['usersId'], $_SESSION['userid'])){
                    displayPosts($conn, $rows['usersId']);
                }
                
            }
        }
    ?>
</div>


<?php
    include_once 'footer.php';
?>