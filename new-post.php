<?php
    include_once 'header.php';
    if(!isset($_SESSION["useruid"])){
        header("location: ../index.php");
        exit();
    }
?>


<div id="new-post">
    <h2>Create a Mog</h2>
    <script src="js/new-post.js"></script>
    <form id="new-post-form"action="includes/new-post.inc.php" method="post" enctype="multipart/form-data">
        <input list="tag-list" name="tag" placeHolder="Tag...">
        <input id="targetNbIpt_id" type="hidden" name="targetNbIpt" value="0">
        <button type="submit" name="submit-post">Publish</button>
        <br>
        <input type="button" id="qButton" value="Add Text" onclick="javascript: addText();"/>
        <input type="button" id="pButton" value="Add Photo/Video" onclick="javascript: addIllustration();"/>
    </form>
</div>

<datalist id="tag-list">
    <option value="Gym">Gym</option>
    <option value="Football">Football</option>
    <option value="Badminton">Badminton</option>
    <option value="Trail">Trail</option>
</datalist>
<?php
    include_once 'footer.php';
?>