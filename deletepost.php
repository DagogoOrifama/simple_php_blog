<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php
//ob_start();
if(isset($_POST['submit'])){
    $DeleteFromURL = $_GET['delete']; 
    $query = "DELETE FROM admin_panel WHERE id='{$DeleteFromURL}'";

    $execute = mysqli_query($connection, $query);
    // move the uploaded file to the upload directory ($imageTarget)
    //move_uploaded_file($_FILES['image']['tmp_name'], $imageTarget);
    if(mysqli_affected_rows($connection) == 1){
        $_SESSION['success_message'] = "Post deleted Successfully";
        redirect_to("dashboard.php");
    }else{
        $_SESSION['error_message'] = "Something went wrong";
        redirect_to("dashboard.php");
   
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
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Admin Dashboard | Delete Post</title>

    <style>
    .fieldInfo{
    color: rgb(251,174, 44);
    font-family: Bitter, georgia, 'Times New Roman', Times, serif;
    font-size: 1.2em;
    }
    </style>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <ul class="nav nav-pills nav-stacked" id="side_menu">
                    <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a></li>
                    <li  class="active"><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Add New Post</a></li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tag"></span>&nbsp; Categories</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Manage Admins</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp; Comments</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp; Live Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
                </ul>
            </div> 
            <div class="col-sm-10">
                <h1>Delete Post</h1>
                <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                <div>
                    <?php
                        $idFromURL = $_GET['delete'];
                        $query = "SELECT * FROM admin_panel WHERE id='$idFromURL'";
                        $execute = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_array($execute)){
                            $title= $row['title'];
                            $category= $row['category'];
                            $imageToBeUpdated = $row['image'];
                            $postToBeUpdated = $row['post'];
                        }

                    ?>
                    <!-- add encype to allow table support images-->
                    <form action="deletepost.php?delete=<?php echo $idFromURL; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">         
                                <!--fieldInfo is a user created class -->                   
                            <label for="title"><span class="fieldInfo">Title:</span></label>
                            <input disabled type="text" name="title" class="form-control" value="<?php echo $title; ?>" id="title" placeholder="Enter Caterory Name">
                            </div>
                            <div class="form-group">  
                            <span class="fieldInfo">
                                Existing Category:  </span>   
                            <?php echo $category; ?>
                            <br>
                            <label for="category"><span class="fieldInfo">Category:</span></label>
                            <select disabled name="category" id="category" class="form-control">
                            <?php
                            // Get available categories from Database and populate the options
                                $query = "SELECT * FROM category ORDER BY datetime DESC";
                                $result = mysqli_query($connection, $query);
                                 while($rows = mysqli_fetch_array($result)):
                                    $category_name = $rows['name'];
                     
                                ?>
                                    <option value="<?php echo $category_name; ?>"><?php echo $category_name; ?></option>
                                <?php endwhile;?>
                            </select>    
                        </div>
                        <div class="form-group">    
                        <span class="fieldInfo">
                                Existing Image:  </span>   
                           <img src="upload/<?php echo $imageToBeUpdated; ?>" width="170px"; height="70">  
                           <br>    
                            <label for="imageSelect"><span class="fieldInfo">Select Image:</span></label>
                            <input disabled type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="form-group">         
                            <label for="post"><span class="fieldInfo">Post:</span></label>
                            <textarea disabled name="post" id="post" class="form-control"><?php echo $postToBeUpdated; ?></textarea>
                        </div>
                            <br>
                            <input type="submit" class="btn btn-danger btn-block" name="submit" value="Delete Post">
                            <br><br>
                        </fieldset>
                    </form>
                </div>  
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