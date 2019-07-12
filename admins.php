<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php
//ob_start();
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($connection, $_POST['confirm_password']);
    date_default_timezone_set("Europe/London");
    $currentTime = time();
    // $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $addedby = $_SESSION['username'];
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    if(empty($username) ||  empty($password)  || empty($confirm_password)){
        $_SESSION['error_message'] = "All fields must be filled out";
        redirect_to("admins.php");
    }elseif(strlen($password) < 4){
        $_SESSION['error_message'] = "Password must be atleast 4 characters";
        redirect_to("admins.php");
    }elseif($password  !== $confirm_password){
        $_SESSION['error_message'] = "Password/confirm password must be the same";
        redirect_to("admins.php");
    }else{
        $query = "INSERT INTO registration (datetime, username, password, addedby) 
                    VALUES('$dateTime', '$username', '$password', '$addedby')";

        $execute = mysqli_query($connection, $query);
        if($execute){
            $_SESSION['success_message'] = "Admin Added Successfully";
            redirect_to("admins.php");
        }else{
            $_SESSION['error_message'] = "Something went wrong";
            redirect_to("admins.php");
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
    </style>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Admin Dashboard | Manage Admins</title>

</head>
<body>
<div style="height:10px; background:#27aae1;"></div>
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
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a></li>
                    <li class="active"><a href="blog.php" target="_blank">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Features</a></li>
                </ul>
               <form action="blog.php" class="navbar-form navbar-right" method="GET">
                   <div class="form-group">
                       <input type="text" class="form-control" placeholder="Search" name="search">
                       <button class="btn btn-default" name="searchButton">Go</button>
                   </div>
               </form>
               </div>     
        </div>
    </nav>
    <div class="line" style="height:10px; background:#27aae1;"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
            <br><br>
                <ul class="nav nav-pills nav-stacked" id="side_menu">
                    <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a></li>
                    <li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tag"></span>&nbsp; Categories</a></li>
                    <li  class="active"><a href="admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
                </ul>
            </div> 
            <div class="col-sm-10">
                <h1>Manage Admins Access</h1>
                <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                <div>
                    <form action="admins.php" method="POST">
                        <fieldset>
                            <div class="form-group">         
                                <!--fieldInfo is a user created class -->                   
                            <label for="username"><span class="fieldInfo">Username:</span></label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
                            </div>
                            <div class="form-group">         
                                <!--fieldInfo is a user created class -->                   
                            <label for="password"><span class="fieldInfo">Password:</span></label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                            </div>
                            <div class="form-group">         
                                <!--fieldInfo is a user created class -->                   
                            <label for="confirm_password"><span class="fieldInfo">Name:</span></label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Retype Password">
                            </div>
                            <br>
                            <input type="submit" class="btn btn-success btn-block" name="submit" value="Add New Site Administrator">
                            <br><br>
                        </fieldset>
                    </form>
                </div>  
                 <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr No.</th>
                        <th>Date & Time</th>
                        <th>Admin Name</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $query = "SELECT * FROM registration ORDER BY id DESC";
                        $result = mysqli_query($connection, $query);
                        // variable used to track the while loop below
                        $SrNo = 0;

                        while($rows = mysqli_fetch_array($result)):
                            $id = $rows['id'];
                            $dateTime = $rows['datetime']; 
                            $username = $rows['username'];
                            $addedby = $rows['addedby'];
                            $SrNo++;                        
                        ?>
                           <tr>
                               <td><?php echo $SrNo; ?></td>
                               <td><?php echo $dateTime; ?></td>
                               <td><?php echo $username; ?></td>
                               <td><?php echo $addedby; ?></td>
                               <th><a href="delete_admin.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></th>
                           </tr> 

                        <?php endwhile;?>
                    
                </table>
                </div>
            </div>
        </div> <!-- Ending of row -->
    </div>  <!-- Ending of container -->
    <div id="footer">
        <hr>
        <p>Theme By | Dagogo Orifama | &copy; 2019 --- All right reserved</p>
        <a style="color:white; text-decoration:none; cursor:point; font-weight:bold;" 
            href="">
        <p>
            This site is onl used for stydy purpose and reserve all the right,  no one is allowed to distribute 
            copies other than <br>&trade; dmisolutions.com &trade; facebook &trade; instagram
        </p>
        <hr>
        </a>
    </div>
    <div style="height:10px; background:#27aae1;" ></div>
</body>
</html>