<?php
    include_once 'header.php';
?>


<div id="signup-form">
    <h2>Sign up</h2>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="name" placeHolder="Full name...">
        <input type="text" name="email" placeHolder="E-mail...">
        <input type="text" name="uid" placeHolder="Username...">
        <input type="password" name="pwd" placeHolder="Password...">
        <input type="password" name="pwdRepeat" placeHolder="Repeat password...">
        <button type="submit" name="submit">Sign up</button>
    </form>
    <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"){
                echo "<p>Fill all fields !</p>";
            }
            else if($_GET["error"] == "invaliduid"){
                echo "<p>Your username must contain Character or Number !</p>";
            }
            else if($_GET["error"] == "invalidemail"){
                echo "<p>Your e-mail is invalid !</p>";
            }
            else if($_GET["error"] == "passwordsdontmatch"){
                echo "<p>Your passwords must be identical !</p>";
            }
            else if($_GET["error"] == "usernametaken"){
                echo "<p>Your username is already took ! Try another one.</p>";
            }
            else if($_GET["error"] == "stmtfailed"){
                echo "<p>Something went wrong. Try again :p</p>";
            }
            else if($_GET["error"] == "none"){
                echo "<p>You have signed up !</p>";
            }
        }
    ?>
</div>



<?php
    include_once 'footer.php';
?>