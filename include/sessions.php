<?php
session_start();
    function error_message(){
        if(isset($_SESSION['error_message'])){
            $output = "<div class=\"alert alert-danger\">";
            $output .= htmlentities($_SESSION['error_message']);
            $output .= "</div>";
            $_SESSION['error_message'] = NULL;
            return $output;
    }
}

    function success_message(){
        if(isset($_SESSION['success_message'])){
            $output = "<div class=\"alert alert-success\">";
            $output .= htmlentities($_SESSION['success_message']);
            $output .= "</div>";
            $_SESSION['success_message'] = NULL;
            return $output;
    }
}

?>