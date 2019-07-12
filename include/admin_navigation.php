<?php
// check is the admin navigation has been clicked upon
if(isset($_GET['id'])){
  $id = $_GET['id'];
}else{
  $id = NULL;
}
  function admin_nav(){
    global $connection;
    global $id;
    $output =   "<ul class='nav nav-pills nav-stacked' id='side_menu'>";
    $output .=  "<li ";
    if($id == 1){
      $output .= "class='active'";
     }
    $output .=  "><a href='dashboard.php?id=1'><span class='glyphicon glyphicon-th'></span>&nbsp; Dashboard</a></li>";
    
    $output .=  "<li ";
      if($id == 2){
        $output .= "class='active'";
      }
    $output .=  "><a href='addNewPost.php?id=2'><span class='glyphicon glyphicon-list-alt'></span>&nbsp; Add New Post</a></li>";
    
    $output .=  "<li ";
    if($id == 3){
      $output .= "class='active'";
    }
    $output .=  "><a href='categories.php?id=3'><span class='glyphicon glyphicon-tag'></span>&nbsp; Categories</a></li>";
   
    $output .=  "<li ";
    if($id == 4){
      $output .= "class='active'";
    }
    $output .=  "><a href='admins.php?id=4'><span class='glyphicon glyphicon-user'></span>&nbsp; Manage Admins</a></li>";
    
    $output .=  "<li ";
    if($id == 5){
      $output .= "class='active'";
    }
    $output .=  "><a href='comments.php?id=5'><span class='glyphicon glyphicon-comment'></span>&nbsp; Comments";
      //<!-- Show the total number of unapproved comments not relevant to any post as a label-->

      
      // SQL function COUNT used to count data in a table
          $query_unapproved_total = "SELECT COUNT(*) FROM comments WHERE status='OFF'";
          $execute_unapproved_total = mysqli_query($connection, $query_unapproved_total);
          $unapproved_rows_total = mysqli_fetch_array($execute_unapproved_total);
          $total_unapproved_total = array_shift($unapproved_rows_total);
          
          if($total_unapproved_total > 0){
            $output .= "<span class='label label-warning pull-right'>";
            $output .= $total_unapproved_total; 
            $output .= "</span>";   
          }
    $output .= "</a></li>";
    $output .=  "<li ";
    $output .= "><a href='blog.php' target='_blank'><span class='glyphicon glyphicon-equalizer'></span>&nbsp; Live Blog</a></li>";
    $output .= "<li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span>&nbsp; Logout</a></li>";
    $output .= "</ul>";
    return $output;

}

?>