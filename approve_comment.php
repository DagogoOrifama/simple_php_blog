
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $approvedby = $_SESSION['username'];
        $query = "UPDATE comments SET status='ON', approvedby='$approvedby' WHERE id='$id'";
        $execute = mysqli_query($connection, $query);
        if($execute){
            $_SESSION['success_message'] = "Comment Approved Successfully";
            redirect_to("comments.php");
        }else{
            $_SESSION['error_message'] = "Something went wrong";
            redirect_to("comments.php");
        }
    }

?>