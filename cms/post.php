<?php include "includes/header.php" ?>
<?php include "includes/db.php" ?>
<?php include "includes/navigation.php"  ?>

<?php 

if(isset($_POST['liked'])){

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    //1 = FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    if(mysqli_num_rows($postResult) >= 1){
        echo $post_id;
    }




    //2 = UPDATE POST WITH LIKES
    mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

    //3 = CREATE LIKES FOR POST
    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");

    exit();

}

if(isset($_POST['unliked'])){

    echo 'unliked';


    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    //1 = FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    //2 = DELETE LIKES

    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");

    //3 = UPDATE DECREMENT LIKES

    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

    exit();

   



}

?>

<!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php 
                if(isset($_GET['p_id'])){
                $the_post_id = $_GET['p_id'];
                $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id";
                $add_view_count_query = mysqli_query($connection, $query);
                confirmQuery($add_view_count_query);
                ?>
               
                <h1 class="page-header">
                    Post
                </h1>
                    
       <!-- Blog Posts -->
         <?php 
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";  
            }
            else{
                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} AND post_status = 'published'";  
            }
                    
                    
            
                    $result = mysqli_query($connection,$query);

                    if(mysqli_num_rows($result) < 1){
                        echo "<h1 class='text-center'> NO POSTS AVAILABLE </h1>";
                    }
                    else {

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
         ?>
                                <h2>
                                    <a href="#"><?php echo $post_title?></a>
                                </h2>
                                <p class='lead'>
                                    by <a href='index.php'><?php echo $post_author?></a>
                                </p>
                                <p><span class='glyphicon glyphicon-time'></span> Posted on <?php echo $post_date?></p>
                                <hr>
                                <img class='img-responsive' src='../images/<?php echo $post_image ?>' alt='' style="width:900px; height:300px;">
                                <br>
                                <?php echo $post_content; ?>
                                <hr>


                        <?php if(isLoggedIn()){?>

                            <div class="row">
                            <p class="pull-right"><a href="" class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>">  
                            <span class="<?php echo userLikedThisPost($the_post_id) ? '' : 'glyphicon glyphicon-thumbs-up'; ?>"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="<?php echo userLikedThisPost($the_post_id) ? 'I liked this before' : 'Want to like it?'; ?>"
                            ></span>  
                            <?php echo userLikedThisPost($the_post_id) ? 'Unlike' : 'Like'; ?></a></p>

                            
                             
                        </div>
                        <div class="row">
                            <p class="pull-right">Like : <?php getPostLike($the_post_id);?></p>
                        </div>

                        <div class="clearfix"></div>

                        <?php } else {?>
                        
                        <div class="row">
                            <p class="pull-right login-to-post">You need to be <a href="../login.php"><u>logged in</u></a> to like</p> 
                        </div>

                        <?php } ?>
        <?php
                    }
                  
                
        ?>
             
             
                <!-- Blog Comments -->

               
               <?php 
                
                if(isset($_POST['create_comment'])){
                    $the_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];

                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                        $query = "INSERT INTO comments (comment_post_id, comment_author,comment_email,comment_content,comment_status,comment_date)";
                        $query .= "VALUES ('{$the_post_id}', '{$comment_author}','{$comment_email}','{$comment_content}','unapproved',now())";
                        $create_comment_query = mysqli_query($connection, $query);
                        confirmQuery($create_comment_query);
                        
                        
                        

                        // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                        // $query .= "WHERE post_id = {$the_post_id}";
                        // $add_comment_count = mysqli_query($connection, $query);
                        // confirmQuery($add_comment_count);
                        
                    }

                }
            
            }



                ?>
               
               
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form" name="post_comment_form">
                        <div class="form-group">
                          
                            <div class="form-group">
                                <label for="Author">Author</label>
                                <input class="form-control" type="text" name="comment_author" id="a">
                            </div>

                            <div class="form-group">
                               <label for="Email">Email</label>
                                <input class="form-control" type="email" name="comment_email" id="b">
                            </div>

                            <label for="Comment">Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3" id="c"></textarea>

                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                
                   
                   
                   <?php 
                
                    $query = "SELECT * FROM comments WHERE comment_post_id = '{$the_post_id}' ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);
                    if(!$select_comment_query){
                        die('Query Failed ' . mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_array($select_comment_query)){
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                    
                    ?>
                    <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
                    
                    <?php 
                    }}
                    else {
                        header("Location: index.php");
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

<script>
//liking
                $(document).ready(function(){

                    var post_id = <?php echo $the_post_id; ?>

                    var user_id = <?php echo loggedInUserId(); ?>;

                    $('.like').click(function(){
                        $.ajax({
                            url:"/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                            type: 'post',
                            data: {
                                'liked': 1,
                                'post_id': post_id,
                                'user_id': user_id
                            }
                        })
                    });

                });

//unlikink
$(document).ready(function(){

    $("[data-toggle='tooltip']").tooltip();

var post_id = <?php echo $the_post_id; ?>;

var user_id = <?php echo loggedInUserId();?>;

$('.unlike').click(function(){
    $.ajax({
        url:"/cms/post.php?p_id=<?php echo $the_post_id; ?>",
        type: 'post',
        data: {
            'unliked': 1,
            'post_id': post_id,
            'user_id': user_id
        }
    })
});

});

</script>