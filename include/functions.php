<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
    function redirect_to($location){
        if(!$location == NULL){
        header("Location: {$location}");
        exit;
        }
    }
    function login_attempt($username, $password){
        global $connection;
        $query = "SELECT * FROM registration 
                     WHERE username='$username' && 
                     password='$password'";
        $execute = mysqli_query($connection, $query);
        if($admin = mysqli_fetch_assoc($execute)){
            return $admin;
        }else{
            return NULL;
        }
    }
    function login(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
    }
    function confirm_login(){
        if(!login()){
            $_SESSION['error_message'] = "Login Required";
            redirect_to("login.php");
        }
    }

?>