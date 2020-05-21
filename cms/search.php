<?php include "includes/header.php" ?>
<?php include "includes/db.php" ?>
<?php include "includes/navigation.php"  ?>

<?php


?>

<!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
       <!-- Blog Posts -->
         <?php 
           
                if(isset($_POST['submit']))
                {
                    $search = $_POST['search'];
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                    $search_query = mysqli_query($connection,$query);
                        if (!$search_query)
                        {
                            die("Query FAILED" . mysqli_error($connection));
                        }
                    $count = mysqli_num_rows($search_query);
                        if($count == 0)
                        {
                            echo "count is equal to zero";
                        }
                        else
                        {
                                   
                        while($row = mysqli_fetch_assoc($search_query))
                            {
                 ?>
                                        <h2>
                                            <a href="#"><?php echo $row['post_title']?></a>
                                        </h2>
                                        <p class='lead'>
                                            by <a href='index.php'><?php echo $row['post_author']?></a>
                                        </p>
                                        <p><span class='glyphicon glyphicon-time'></span> Posted on <?php echo $row['post_date']?></p>
                                        <hr>
                                        <img class='img-responsive' src='images/900x300.png' alt=''>
                                        <hr>
                                        <p><?php echo $row['post_content']?></p>
                                        <a class='btn btn-primary' href='#'>Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                                        <hr>
<?php
                            } 
                        }
                } 
                
          
                    
    ?>
             
            </div>
                <!-- Blog Sidebar Widgets Column -->
          <?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
 <!-- Footer -->
<?php include "includes/footer.php" ?>