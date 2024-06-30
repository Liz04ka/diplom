<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require("db.php");

    if (isset($_POST['return'])) {

        $id = $_POST['id'];
        $comment = $_POST['comment'];
        $course = $db->query("SELECT id_course FROM `requests` WHERE id=$id")->fetchColumn();

        $db->query("UPDATE requests SET status='return' WHERE id=$id");
        $db->query("UPDATE requests SET comment='$comment' WHERE id=$id");

        header('Location:request.php?id='.$course);   
    }
}


?>