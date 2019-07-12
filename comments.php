
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/admin_navigation.php"); ?>
<?php confirm_login(); ?>
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
            <br> <br>
            <?php  echo admin_nav(); ?>
            </div> 
            <div class="col-sm-10">
            <div> <?php echo error_message(); 
                            echo success_message();
                ?></div>
                <h1>Un-Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approve</th>
                                <th>Delete Comment</th>
                                <th>Details</th>
                            </tr> 
                            <?php
                                $query = "SELECT * FROM comments WHERE status='OFF'  ORDER BY id DESC";
                                $execute = mysqli_query($connection, $query);
                                $SrNo = 0;
                                while($row = mysqli_fetch_array($execute)):
                                    $commentId = $row['id'];
                                    $datetime = $row['datetime'];
                                    $person_name = $row['name'];
                                    $person_comment = $row['comment'];
                                    $commented_post_id = $row['admin_panel_id'];
                                    $SrNo++;

                                ?>
                                <tr>
                                    <td><?php echo $SrNo; ?></td>
                                    <td style="color:blue"><?php echo $person_name; ?></td>
                                    <td><?php echo $datetime; ?></td>
                                    <td><?php echo $person_comment; ?></td>
                                    
                                    <td><a href="approve_comment.php?id=<?php echo $commentId; ?>"><span class="btn btn-success">Approve</span></a></td>
                                    <td><a href="delete_comment.php?id=<?php echo $commentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                    <td><a href="fullpost.php?id=<?php echo $commented_post_id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                                </tr>
                                <?php endwhile; ?>

                        </table>
                    </div> <!-- end of approve comment table -->

                    <h1>Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approved By</th>
                                <th>Revert Approval</th>
                                <th>Delete Comment</th>
                                <th>Details</th>
                            </tr> 
                            <?php
                                $query = "SELECT * FROM comments WHERE status='ON'  ORDER BY id DESC";
                                $execute = mysqli_query($connection, $query);
                                $SrNo = 0;
                                while($row = mysqli_fetch_array($execute)):
                                    $commentId = $row['id'];
                                    $datetime = $row['datetime'];
                                    $person_name = $row['name'];
                                    $person_comment = $row['comment'];
                                    $approvedby = $row['approvedby'];
                                    $commented_post_id = $row['admin_panel_id'];
                                    $SrNo++;

                                ?>
                                <tr>
                                    <td><?php echo $SrNo; ?></td>
                                    <td style="color:blue"><?php echo $person_name; ?></td>
                                    <td><?php echo $datetime; ?></td>
                                    <td><?php echo htmlentities($person_comment); ?></td>
                                    <td><?php echo htmlentities($approvedby); ?></td>
                                    <td><a href="disapprove_comment.php?id=<?php echo $commentId; ?>"><span class="btn btn-warning">Disapprove</span></a></td>
                                    <td><a href="delete_comment.php?id=<?php echo $commentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                                    <td><a href="fullpost.php?id=<?php echo $commented_post_id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                                </tr>
                                <?php endwhile; ?>

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