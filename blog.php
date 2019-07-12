<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
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
        .nav ul li{
            float: left;
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
            <p class="lead">The best site for latest information by Dagogo Orifama</p>
        </div>
        <div class="row">
                    <div class="col-sm-8">
                        <?php 
                        // working on the search button, if the user made a search use
                        // this query
                            if(isset($_GET['searchButton'])){
                                $search = $_GET['search'];
                                $query = "SELECT * FROM admin_panel WHERE ";  
                                $query .= "datetime LIKE '%$search%' OR "; 
                                $query .= "title LIKE '%$search%' OR ";
                                $query .= "category LIKE '%$search%' OR "; 
                                $query .= "post LIKE '%$search%'  ORDER BY id DESC";
                            }elseif(isset($_GET['category'])){
                                // Query is activated when a categor is selected on the blog
                                // Query to show 5 post starting from $show_post_from
                                $category = $_GET['category'];
                                $query = "SELECT * FROM admin_panel WHERE category='$category' ORDER BY id DESC"; 
                                
                            }elseif(isset($_GET['page'])){
                            // Adding pagination to blog page
                            // Query when pagination is active example (blog.php?page=1)
                            $page = $_GET['page'];
                            if($page <= 0){
                                $show_post_from = 0;
                            }else{
                            // Pagination logic
                            $show_post_from = ($page*5)-5;
                            }
                            // Query to show 5 post starting from $show_post_from
                            $query = "SELECT * FROM admin_panel  ORDER BY id DESC LIMIT $show_post_from,5"; 
                             
                            
                            }else{ // otherwise use the normal query
                            $query = "SELECT * FROM admin_panel  ORDER BY id DESC LIMIT 0,5"; 
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
                                     <?php echo htmlentities($datetime); ?> 
                                    
                                     <?php
                                        // Show all approved comments for a specific post as a label
                                        // SQL function COUNT used to count data in a table
                                            $query_approved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$postId' && status='ON'";
                                            $execute_approved = mysqli_query($connection, $query_approved);
                                            $approved_rows = mysqli_fetch_array($execute_approved);
                                            $total_approved = array_shift($approved_rows);
                                            
                                            if($total_approved > 0): ?>
                                            <span class="badge pull-right"><?php 
                                             echo "Comments: ".$total_approved; ?></span>   
                                            <?php endif; ?>

                                    </p>
                                       <!-- post is user-defined -->
                                     <p class="post"><?php 
                                     // checks if post is greater than 150, if true the show only from 0-150 character

                                     if(strlen($post)>150){$post = substr($post,0,150). '...'; }
                                     echo htmlentities($post); ?></p>
                                </div>
                                <a href="fullpost.php?id=<?php echo $postId; ?>"><span class="btn btn-info">
                                    Read More &rsaquo;&rsaquo;
                                </span> </a>
                            </div>
                               
                            <?php endwhile;  ?>


                            <!-- // Creating pagination link -->
                            <nav>
                                <ul class="pagination pull-left pagination-lg">
                                <?php 
                                // Creating back button
                                if(isset($page)):
                                    if($page>1): ?>
                                    <li><a href="blog.php?page=<?php echo $page-1; ?>">&laquo;</a></li>
                                
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php
                            // Creating pagination link logic
                                $query_pagination = "SELECT COUNT(*) FROM admin_panel";
                                $execute_pagination = mysqli_query($connection, $query_pagination);
                                $rows_pagination = mysqli_fetch_array($execute_pagination);
                                $total_posts = array_shift($rows_pagination);
                                // total paes for showing  posts per page
                                $total_pages = $total_posts/5;
                                // if division is not a whole number then take the ceil of the number to round it up
                                $total_pages = ceil($total_pages);
                                // $page = $_GET['page'];
                                for($i=1; $i <= $total_pages; $i++): 
                                    if(isset($page)):
                                    if($i == $page): ?>
                                        <!-- show pagination with an active class-->
                                     <li class="active"><a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li> 
                                <?php else: ?>
                                 <!--show pagination link without active class-->
                               <li><a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li> 
                               <?php endif; ?>
                               <?php endif; ?>
                               <?php endfor; ?>

                               <?php 
                               // Creating forward button
                               if(isset($page)):
                                    if($page+1 <= $total_pages): ?>
                                    <li><a href="blog.php?page=<?php echo $page+1; ?>">&raquo;</a></li>
                             <?php endif ?>   
                            <?php endif; ?>
                                </ul>
                                </nav>
                       
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
                            $query = "SELECT * FROM category ORDER BY id DESC";
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