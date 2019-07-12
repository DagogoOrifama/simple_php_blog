<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php
//ob_start();
if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $post = mysqli_real_escape_string($connection, $_POST['post']);
    date_default_timezone_set("Europe/London");
    $currentTime = time();
    // $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $image = $_FILES['image']['name'];
    $imageTarget = "upload/".basename($_FILES['image']['name']);
    $admin = $_SESSION['username'];
    if(empty($title)){
        $_SESSION['error_message'] = "Post title cannot be empty";
        redirect_to("addNewPost.php");
    }elseif(strlen($title) > 200){
        $_SESSION['error_message'] = "Post title is too long";
        redirect_to("addNewPost.php");
    }else{
        $query = "INSERT INTO admin_panel (datetime, title, category, author, image, post) 
                    VALUES('$dateTime', '$title', '$category', '$admin', '$image', '$post')";

        $execute = mysqli_query($connection, $query);
        // move the uploaded file to the upload directory ($imageTarget)
        move_uploaded_file($_FILES['image']['tmp_name'], $imageTarget);
        if($execute){
            $_SESSION['success_message'] = "Post added Successfully";
            redirect_to("addNewPost.php");
        }else{
            $_SESSION['error_message'] = "Post creation failed";
            redirect_to("addNewPost.php");
        }

    }
   
}
//ob_end_clean();
?>
<?php require_once("include/admin_header.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <br><br>
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
                <h1>Add New Post</h1>
                <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                <div>
                    <!-- add encype to allow table support images-->
                    <form action="addNewPost.php" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">         
                                <!--fieldInfo is a user created class -->                   
                            <label for="title"><span class="fieldInfo">Title:</span></label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Caterory Name">
                            </div>
                            <div class="form-group">         
                            <label for="category"><span class="fieldInfo">Category:</span></label>
                            <select name="category" id="category" class="form-control">
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
                            <label for="imageSelect"><span class="fieldInfo">Select Image:</span></label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="form-group">         
                            <label for="post"><span class="fieldInfo">Post:</span></label>
                            <textarea name="post" id="post" class="form-control"></textarea>
                        </div>
                            <br>
                            <input type="submit" class="btn btn-success btn-block" name="submit" value="Create Post">
                            <br><br>
                        </fieldset>
                    </form>
                </div>  
                </div>
            </div>
        </div> <!-- Ending of row -->
    </div>  <!-- Ending of container -->
    <?php require_once("include/admin_footer.php"); ?>