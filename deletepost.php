<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/admin_navigation.php"); ?>
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

<?php require_once("include/admin_header.php"); ?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
            <?php  echo admin_nav(); ?>
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
    <?php require_once("include/admin_footer.php"); ?>