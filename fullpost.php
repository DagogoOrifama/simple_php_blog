<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php
//ob_start();
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $comment = mysqli_real_escape_string($connection, $_POST['comment']);
    date_default_timezone_set("Europe/London");
    $currentTime = time();
    // $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
    $dateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $postId = $_GET['id'];
    if(empty($name) || empty($email) || empty($comment)){
        $_SESSION['error_message'] = "All field are required";
    }elseif(strlen($comment) > 500){
        $_SESSION['error_message'] = "Comment must not be more than 500 charater";
    }else{
        $query = "INSERT INTO comments (datetime, name, email, comment, status, approvedby, admin_panel_id) 
                    VALUES('$dateTime', '$name', '$email', '$comment', 'OFF', 'pending', '$postId')";

        $execute = mysqli_query($connection, $query);
        if($execute){
            $_SESSION['success_message'] = "Comment Submitted Successfully";
            redirect_to("fullPost.php?id={$postId}");
        }else{
            $_SESSION['error_message'] = "Comment creation failed";
            redirect_to("fullPost.php?id={$postId}");
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
    <link rel="stylesheet" href="css/publicstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Welcome to Dmi Blog</title>
    <style>
        .fieldInfo{
        color: rgb(251,174, 44);
        font-family: Bitter, georgia, 'Times New Roman', Times, serif;
        font-size: 1.2em;
        }
        .commentBlock{
            background-color: #f6f7f9;
        }
        .commentInfo{
            color: #365899;
            font-family:sans-serif;
            font-size:1.1em;
            font-weight:bold;
            padding-top:10px;
        }
        .comment{
            margin-top: 2px;
            padding-bottom:10px;
            font-size:1.1em;
        }
        .image_icon{
            max-width: 150px;
            margin: 0, auto;
            display: block;
        }
        .panel_background{
            background-color: #F6F7F9;
        }
    </style>
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
                    <li class="active"><a href="blog.php">Blog</a></li>
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
    <div class="container">
        <div class="blog-header">
            <h1>The complete Responsive CMS Blog</h1>
            <p class="lead">The best site for information by Dagogo Orifama</p>
        </div>
        <div class="row">
                    <div class="col-sm-8">
                    <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                        <?php 
                        // working on the search button, if the user made a search use
                        // this query
                            if(isset($_GET['searchButton'])){
                                $search = $_GET['search'];
                                $query = "SELECT * FROM admin_panel WHERE ";  
                                $query .= "datetime LIKE '%$search%' OR "; 
                                $query .= "title LIKE '%$search%' OR ";
                                $query .= "category LIKE '%$search%' OR "; 
                                $query .= "post LIKE '%$search%'";
                            }else{ // otherwise use the normal query
                            $postIdFromURL = $_GET['id'];
                            $query = "SELECT * FROM admin_panel WHERE id = '$postIdFromURL'   ORDER BY id DESC"; 
                                }
                            $execute = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_array($execute)):
                                $postId =  $row['id'];
                                $datetime = $row['datetime'];
                                $title= $row['title'];
                                $category= $row['category'];
                                $author  = $row['author'];
                                $image= $row['image'];
                                $post = $row['post'];
                            ?>
                            <!-- blopost is user-defined -->
                            <div class="blogpost thumbnail">
                                <img class="img-responsive img-rounded" src="upload/<?php echo $image; ?>">
                                <div class="caption">
                                    <h1 id="heading"><?php echo htmlentities($title); ?></h1>
                                    <!-- description is user-defined -->
                                    <p class="description">Cateory:<?php echo htmlentities($category); ?> Pulished on
                                     <?php echo htmlentities($datetime); ?> </p>
                                       <!-- post is user-defined, nl2br to convert newline to line break  -->
                                     <p class="post"><?php echo nl2br($post); ?></p>
                                </div>
                            </div>
                               
                            <?php endwhile;  ?>
                                <br><br>
                                <br><br>
                             <span class="fieldInfo">Comment</span>
                            <?php
                                 $postId = $_GET['id'];
                                 $query = "SELECT * FROM comments WHERE admin_panel_id ='$postId' && status='ON' ORDER BY datetime DESC";
                                 $execute = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($execute)):
                                    $comment_date = $row['datetime'];
                                    $commenter_name = $row['name'];
                                    $comment_by_user = $row['comment'];
                                    
                                ?>
                                <div class="commentBlock"> 
                                <img style="margin-left:10px; margin-right:10px; margin-top:10px" class="pull-left" src="images/comment.png" width="70" height="70">
                                    <p class="commentInfo"><?php echo $commenter_name; ?></p>
                                    <p class="description"><?php echo $comment_date; ?></p>
                                    <p class="comment"><?php echo nl2br($comment_by_user); ?></p>
                                </div>
                                <hr>
                                <?php endwhile; ?>

                             <br>
                            <span class="fieldInfo">Share your thoughts on this post</span>
                         
                           

                    <form action="fullPost.php?id=<?php echo $postId; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">                        
                            <label for="name"><span class="fieldInfo">Name:</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                            </div>
                            <div class="form-group">                    
                            <label for="title"><span class="fieldInfo">Email:</span></label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        <div class="form-group">         
                            <label for="comment"><span class="fieldInfo">Comment:</span></label>
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
                            <br>
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                            <br><br>
                        </fieldset>
                    </form>
                       
                    </div>
                    <div class="col-sm-offset-1 col-sm-3">
                    <h2>About me</h2>
                    <!-- image_icon is a userdefined class -->
                    <img class="img-responsive img-circle image_icon" src="images/Bunny.jpg" alt="">
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquam corporis et voluptate. Unde maxime amet soluta ad aspernatur maiores sit earum deleniti fugit neque at facilis minus, totam repellendus sint.</p>
                    <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h1 class="panel-title">Categories</h1>
                    </div>
                    <div class="panel-body">
                        <?php
                            $query = "SELECT * FROM category";
                            $execute = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_array($execute)):
                                $id = $row['id'];
                                $category = $row['name'];
                            ?>
                            <span id="heading"><a href="blog.php?category=<?php echo $category; ?>"><?php echo $category. "<br>"; ?></a></span>
                            <?php endwhile; ?>
                    </div>
                    <div class="panel-footer"></div>
                    </div>


                    <div class="panel panel-primary panel-responsive">
                    <div class="panel-heading">
                                <h1 class="panel-title">Recent Posts</h1>
                    </div>
                    <!--  panel_background is user-defined -->
                    <div class="panel-body panel_background">
                    <?php
                            $query = "SELECT * FROM admin_panel  ORDER BY id DESC LIMIT 0,5";
                            $execute = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_array($execute)):
                                $id = $row['id'];
                                $title = $row['title'];
                                $datetime = $row['datetime'];
                                $image = $row['image'];
                            if(strlen($datetime) > 11){ $datetime = substr($datetime, 0,11); }
                            ?>
                            <div>                          
                             <img class="pull-left" style="margin-top:10px; margin-left:10px" src="upload/<?php echo htmlentities($image); ?>" width="70px" height="70">
                           <p id="heading" style="margin-left:90px"><a href="fullpost.php?id=<?php echo $id; ?>">
                           <?php echo htmlentities($title); ?></a></p>
                           <p class="description" style="margin-left:90px"><?php echo htmlentities($datetime); ?></p>
                           <hr>
                           </div>
                            <?php endwhile; ?>

                    </div>
                    <div class="panel-footer"></div>
                    </div>

                    </div>
                    </div>
               </div>
    </div>
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