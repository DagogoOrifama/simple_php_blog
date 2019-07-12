
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirm_login(); ?>
<?php require_once("include/admin_header.php"); ?>
<?php require_once("include/admin_navigation.php"); ?>
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
                <h1>Admin Dashboard</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No</th>
                                <th>Post Title</th>
                                <th>Date & Time</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Banner</th>
                                <th>Comments</th>
                                <th>Action</th>
                                <th>Details</th>
                            </tr>
                            <?php 
                                $query = "SELECT * FROM admin_panel ORDER BY id DESC";
                                $execute = mysqli_query($connection, $query);
                                $SrNo = 0;
                                while($row = mysqli_fetch_array($execute)):
                                    $id =  $row['id'];
                                    $datetime = $row['datetime'];
                                    $title= $row['title'];
                                    $category= $row['category'];
                                    $author  = $row['author'];
                                    $image= $row['image'];
                                    $post = $row['post'];
                                    $SrNo++
                                ?>
                                    <tr>
                                        <td><?php echo $SrNo; ?></td>
                                        <td style="color:#5e5eff"><?php
                                        // Limiting the length of the post title to 20 characters
                                        if(strlen($title) > 20){
                                            $title = substr($title, 0, 20). "...";
                                            }
                                             echo $title;
                                         ?></td>
                                        <td><?php 
                                          // Limiting the length of the date to show only date
                                          if(strlen($datetime) > 11){
                                            $datetime = substr($datetime, 0, 11);
                                             }
                                             echo $datetime; ?></td>
                                        <td><?php
                                           // Limiting the length of the author
                                           if(strlen($author) > 6){
                                            $author = substr($author, 0, 6). "...";
                                            }
                                             echo $author; ?></td>
                                        <td><?php 
                                            // Limiting the length of the author
                                           if(strlen($category) > 8){
                                            $category = substr($category, 0, 8). "...";
                                            }
                                        echo $category; ?></td>
                                        <td><img src="upload/<?php echo $image; ?>" width="170px"; height="50px"></td>
                                        <td>
                                            <?php
                                            // Show all approved comments for a specific post as a label
                                            // SQL function COUNT used to count data in a table
                                                $query_approved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' && status='ON'";
                                                $execute_approved = mysqli_query($connection, $query_approved);
                                                $approved_rows = mysqli_fetch_array($execute_approved);
                                                $total_approved = array_shift($approved_rows);
                                                
                                                if($total_approved > 0): ?>
                                                <span class="label label-success pull-right"><?php  echo $total_approved; ?></span>   
                                                <?php endif; ?>

                                                <?php 
                                                // Show all unapproved comments for a specific post as a label
                                            // SQL function COUNT used to count data in a table
                                                $query_unapproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' && status='OFF'";
                                                $execute_unapproved = mysqli_query($connection, $query_unapproved);
                                                $unapproved_rows = mysqli_fetch_array($execute_unapproved);
                                                $total_unapproved = array_shift($unapproved_rows);
                                                
                                                if($total_unapproved > 0): ?>
                                                <span class="label label-danger"><?php  echo $total_unapproved; ?></span>   
                                                <?php endif; ?>
                                        </td>
                                        <td>
                                        <a href="editpost.php?edit=<?php echo $id; ?> "><span class="btn btn-warning">Edit</span></a>
                                        <a href="deletepost.php?delete=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a>
                                        </td>
                                        <td> <a href="fullpost.php?id=<?php echo $id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                                    </tr>
                                <?php endwhile;  ?>
                        </table>
                    </div>
                </div>
        </div> <!-- Ending of row -->
    </div>  <!-- Ending of container -->
    <?php require_once("include/admin_footer.php"); ?>