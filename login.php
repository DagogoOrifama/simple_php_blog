<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php
//ob_start();
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    if(empty($username) ||  empty($password)){
        $_SESSION['error_message'] = "All fields must be filled out";
        redirect_to("login.php");
    }else{
    
        $found_account = login_attempt($username, $password);
        $_SESSION['user_id'] = $found_account['id'];
        $_SESSION['username'] = $found_account['username'];
        if($found_account){
            $_SESSION['success_message'] = "Welcome {$_SESSION['username']}";
            redirect_to("dashboard.php?id=1");
        }else{
            $_SESSION['error_message'] = "Wrong username / password combination";
           redirect_to("login.php");
    }
}
}
   

//ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <style>
    .fieldInfo{
    color: rgb(251,174, 44);
    font-family: Bitter, georgia, 'Times New Roman', Times, serif;
    font-size: 1.2em;
    }
    body{
        background-color:#ffffff;
    }
    </style>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Admin Dashboard | Login</title>

</head>
<body>
<div style="height:5px; background:#27aae1;"></div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collasped" data-toggle="collapse"
                data-target="#collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="blog.php" class="navbar-brand">
                     <img style="margin:-10px" src="images/logo2.png" width=200;height = 30;>
                </a>
                </div>
                <div class="collapse navbar-collapse" id="collapse">
               
               </div>     
        </div>
    </nav>
    <div class="line" style="height:10px; background:#27aae1;"></div>
    <div class="container-fluid">
        <div class="row">
          
            <div class="col-sm-4 col-sm-offset-4">
       
                <br><br>
                <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                <h2>Administrator</h2>
                
                <div>
                    <form action="login.php" method="POST">
                        <fieldset>
                            <div class="form-group">  
                                              
                            <label for="username"><span class="fieldInfo">Username:</span></label>
                            <div class="input-group input-group-lg">  
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-envelope text-primary"></span>
                            </span>
                                <!--fieldInfo is a user created class --> 
                            <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
                            </div>
                            </div>     
                            <div class="form-group">         
                                           
                            <label for="password"><span class="fieldInfo">Password:</span></label>
                            <div class="input-group input-group-lg">  
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-lock text-primary"></span>
                            </span> 
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                            </div>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-info btn-block" name="submit" value="Login">
                            <br><br>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div> <!-- Ending of row -->
        <br><br><br><br><br><br>
    </div>  <!-- Ending of container -->
    <?php require_once("include/admin_footer.php"); ?>