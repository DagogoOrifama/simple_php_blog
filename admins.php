<?php require_once("include/sessions.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php require_once("include/admin_navigation.php"); ?>
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
<?php require_once("include/admin_header.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
            <br> <br>
            <?php  echo admin_nav(); ?>
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
    <?php require_once("include/admin_footer.php"); ?>