<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/navigation.php";
?>

<!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
       <!-- Blog Posts -->
         <?php 


if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
    $select_post_query_count = "SELECT * FROM posts";
}
else{
    $select_post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";  
}

         //pager
         $find_count = mysqli_query($connection,$select_post_query_count);
         $count = mysqli_num_rows($find_count);

         if($count < 1){
            
                echo "<h1 class='text-center'> NO POSTS AVAILABLE </h1>";
            
         } else {

         $how_many_pages = ceil($count/10);
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            $from = ($page * 10) - 10;
        }
        else {
            $page = 1;
            $from = ($page * 10) - 10;
        }
          

                    $query = "SELECT * FROM posts LIMIT " . $from . ", " . 10  ;  
                    $result = mysqli_query($connection,$query);
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0, 100);
                        $post_status = $row['post_status'];    
                        
                 
         ?>
                                <h2>
                                    <a href="post/<?php echo $post_id ?>"><?php echo $post_title?></a>
                                </h2>
                                <p class='lead'>
                                    by <a href='author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>'><?php echo $post_author?></a>
                                </p>
                                <p><span class='glyphicon glyphicon-time'></span> Posted on <?php echo $post_date?></p>
                                <hr>
                                <a href="post.php?p_id=<?php echo $post_id ?>">
                                <img class='img-responsive' src='images/<?php echo $post_image ?>' alt='' style="width:900px; height:300px;">
                                </a>
                                <hr>
                                <p><?php echo $post_content?></p>
                                <a class='btn btn-primary' href="post.php?p_id=<?php echo $post_id ?>">Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                                <hr>
        <?php
                    } }
        ?>
             
            </div>
                <!-- Blog Sidebar Widgets Column -->
          <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <ul class="pager">
        <?php 
        for($i = 1; $i <= $how_many_pages; $i++){
            if($i == $page){
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            }
            else {
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }
        ?>
        </ul>

        <hr>
 <!-- Footer -->
<?php include "includes/footer.php" ?>