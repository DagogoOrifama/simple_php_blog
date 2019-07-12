<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/admin_navigation.php"); ?>
<?php confirm_login(); ?>
<?php
//ob_start();
if(isset($_POST['submit'])){
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    date_default_timezone_set("Europe/London");
    $currentTime = time();
    // $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $admin = $_SESSION['username'];
    if(empty($category)){
        $_SESSION['error_message'] = "All fields must be filled out";
        redirect_to("categories.php");
    }elseif(strlen($category) > 99){
        $_SESSION['error_message'] = "Category Name is too long";
        redirect_to("categories.php");
    }else{
        $query = "INSERT INTO category (datetime, name, creator_name) 
                    VALUES('$dateTime', '$category', '$admin')";

        $execute = mysqli_query($connection, $query);
        if($execute){
            $_SESSION['success_message'] = "Category Added Successfully";
            redirect_to("categories.php");
        }else{
            $_SESSION['error_message'] = "Category creation failed";
            redirect_to("categories.php");
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
    <title>Admin Dashboard</title>

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
            <?php  echo admin_nav(); ?>
            </div> 
            <div class="col-sm-10">
                <h1>Manage Categories</h1>
                <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                <div>
                    <form action="categories.php" method="POST">
                        <fieldset>
                            <div class="form-group">         
                                <!--fieldInfo is a user created class -->                   
                            <label for="categoryname"><span class="fieldInfo">Name:</span></label>
                            <input type="text" name="category" class="form-control" id="category" placeholder="Enter Caterory Name">
                            </div>
                            <br>
                            <input type="submit" class="btn btn-success btn-block" name="submit" value="Add New Category">
                            <br><br>
                        </fieldset>
                    </form>
                </div>  
                 <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr No.</th>
                        <th>Date & Time</th>
                        <th>Category Name</th>
                        <th>Creator Name</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $query = "SELECT * FROM category ORDER BY id DESC";
                        $result = mysqli_query($connection, $query);
                        // variable used to track the while loop below
                        $SrNo = 0;

                        while($rows = mysqli_fetch_array($result)):
                            $id = $rows['id'];
                            $dateTime = $rows['datetime']; 
                            $category_name = $rows['name'];
                            $creator_name = $rows['creator_name'];
                            $SrNo++;                        
                        ?>
                           <tr>
                               <td><?php echo $SrNo; ?></td>
                               <td><?php echo $dateTime; ?></td>
                               <td><?php echo $category_name; ?></td>
                               <td><?php echo $creator_name; ?></td>
                               <th><a href="delete_category.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></th>
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