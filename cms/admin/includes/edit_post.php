<?php
    global $connection;
    if(isset($_GET['p_id']))
    {
       $the_post_id = $_GET['p_id'];
    
        $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";  
        $all_posts_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($all_posts_query))
        {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comments = $row['post_comment_count'];
            $post_date = $row['post_date'];
        }
    
    if(isset($_POST['update_post'])){
            $post_author = $_POST['post_author'];
            $post_title = $_POST['post_title'];
            $post_category_id = $_POST['post_category'];
            $post_status = $_POST['post_status'];
            $post_image = $_FILES['image']['name'];
            $post_image_temp = $_FILES['image']['tmp_name'];
            $post_content = $_POST['post_content'];
            $post_tags = $_POST['post_tags'];
            move_uploaded_file($post_image_temp, "../images/{$post_image}");
        
            if(empty($post_image)){
                $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
                $select_image = mysqli_query($connection,$query);
                while($row = mysqli_fetch_array($select_image)){
                    $post_image = $row['post_image'];
                }
            }
        
            $query = "UPDATE posts SET ";
            $query .="post_title = '{$post_title}', "; 
            $query .="post_category_id = '{$post_category_id}', ";
            $query .="post_date = now(), ";
            $query .="post_author = '{$post_author}', ";
            $query .="post_status = '{$post_status}', ";
            $query .="post_tags = '{$post_tags}', ";
            $query .="post_content = '{$post_content}', ";
            $query .="post_image = '{$post_image}' ";
            $query .= "WHERE post_id = $the_post_id"; 
        $update_post = mysqli_query($connection, $query);
        confirmQuery($update_post);
        
    }
    }
?>
  
   <form action="" method="post" enctype="multipart/form-data">

   <?php if(isset($_GET['p_id'])){
       echo "<p class='bg-success'>Goto: <a href='../post.php?p_id={$the_post_id}'>View this post</a> or <a href='../admin/posts.php'>View All posts</a></p>";
   }?>  

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <textarea  class="form-control" name="post_title" id="" style="resize: none" rows="1"><?php echo $post_title;?></textarea>
    </div>
    
    <div class="form-group">
    <label for="post_category">Post Category</label>
        <select name="post_category" id="post_category" class="form-control">
            
            <?php 
            
            $query = "SELECT * FROM categories";  
            $select_categories = mysqli_query($connection,$query);
            confirmQuery($select_categories);
            while($row = mysqli_fetch_assoc($select_categories))
            {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            if($post_category == $cat_id){
                echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
            }
            else{
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
            }
            ?>
            
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <select name="post_author" id="post_author" class="form-control">

        <?php 

        $query = "SELECT * FROM users";  
        $select_users = mysqli_query($connection,$query);
        confirmQuery($select_users);
        while($row = mysqli_fetch_assoc($select_users))
        {
            $user_id = $row['user_id'];
            $username = $row['username'];
            echo "<option value='{$username}'>{$username}</option>";
        }
        ?>

        </select>
    </div>

    <div class="form-group">
    <label for="post_status">Post Status</label>
            <select name="post_status" id="" class="form-control">
            
                <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
                <?php if($post_status == 'published'){
                    echo "<option value='draft'>Draft</option>";
                }else {
                    echo "<option value='published'>Published</option>";
                } ?>


            </select>
    </div>
    
    <div class="form-group">
        <img width="100" name="image" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image" >
    </div>
    

    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <textarea  class="form-control" name="post_tags" id="" style="resize: none" rows="1"><?php echo $post_tags;?></textarea>
    </div>
    
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea  class="form-control" name="post_content" id="editor" cols="30" rows="10"><?php echo $post_content;?></textarea>
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
    
</form>