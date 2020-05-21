
<?php 

include('delete_modal.php');

if($_SESSION['user_role'] != 'admin'){
    header("Location: ../index.php");
}

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options){
            case 'published' :
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}'";
            $update_to_published_status = mysqli_query($connection,$query);
            confirmQuery($update_to_published_status);
            break;

            case 'draft' :
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}'";
            $update_status = mysqli_query($connection,$query);
            confirmQuery($update_status);
            break;

            case 'delete' :
            $query = "DELETE FROM posts WHERE post_id = '{$postValueId}'";
            $update_status = mysqli_query($connection,$query);
            confirmQuery($update_status);
            break;

            case 'clone' :
            $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}'";
            $select_post_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($select_post_query)){
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_date = $row['post_date'];
                $post_author = $row['post_author'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_content = $row['post_content'];
            }

            $query = "INSERT into posts(post_title, post_category_id, post_date, post_author,";
            $query .=" post_status, post_image, post_tags, post_content) ";
            $query .="VALUES('{$post_title}','{$post_category_id}',now(),";
            $query .="'{$post_author}','{$post_status}','{$post_image}','{$post_tags}','{$post_content}')";

            $clone_post = mysqli_query($connection,$query);
            confirmQuery($clone_post);
            break;

            case 'resetviews' :
            $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$postValueId}'";
            $update_status = mysqli_query($connection,$query);
            confirmQuery($update_status);
            break;
        }
    }
}
?>

<form action="" method="post">
 
<table class="table-bordered table table-hover">

<div id="bulkOptionsContainer" class="col-xs-4" style="padding: 0px">
    <select class="form-control" name="bulk_options" id="">

        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
        <option value="resetviews">Reset views</option>
        
    </select>
    <br>
</div>

<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply">
<a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
</div>

                    <thead>
                        <tr>
                            <th><input id="selectAllBoxes" type="checkbox"></th>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Tags</th>
                            <th>Comments</th>
                            <th>Views</th>
                            <th>Date</th>
                            <th>View Post</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
<?php
  
if(isset($_POST['delete'])){
        $the_post_id = $_POST['post_id'];
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_query = mysqli_query($connection,$query);
        confirmQuery($delete_query);
        
        header("Location: posts.php");
}
                        
?>
                          
                           
    <?php
    global $connection;
    // $query = "SELECT * FROM posts ORDER BY post_id DESC";  
    $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
    $query .= " posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title";
    $query .= " FROM posts ";
    $query .= " LEFT JOIN categories on posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC ";
    $all_posts_query = mysqli_query($connection,$query);
    confirmQuery($all_posts_query);
    while($row = mysqli_fetch_assoc($all_posts_query))
    {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_views = $row['post_views_count'];
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        ?>
        <td><input class='checkBoxes' type='checkbox' name="checkBoxArray[]" value='<?php echo $post_id; ?>'></td>
        <?php
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";
        
            // $query = "SELECT * FROM categories WHERE cat_id = {$post_category}";  
            // $select_categories_id = mysqli_query($connection,$query);
            // while($row = mysqli_fetch_assoc($select_categories_id))
            // {
            //     $cat_id = $row['cat_id'];
            //     $cat_title = $row['cat_title'];
                
            // }
            echo "<td>{$cat_title}</td>";
            echo "<td>{$post_status}</td>";
            echo "<td><img width='200' src='../images/$post_image' alt='image'></td>";
            echo "<td>{$post_tags}</td>";

            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id"; 
            $send_comment_query = mysqli_query($connection, $query);

            $row = mysqli_fetch_array($send_comment_query);
            $comment_id = $row['comment_id'];
            $count_comments = mysqli_num_rows($send_comment_query);


            echo "<td><a href='post_comments.php?p_id={$post_id}'>{$count_comments}</a></td>";
            echo "<td>{$post_views}</td>";
            echo "<td>{$post_date}</td>";
            echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";
            echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

            ?>

            <form action="" method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

                <?php
                echo '<td><input type="submit" name="delete" value="Delete" class="btn btn-danger"></td>';
                ?>
            </form>

            <?php

            // echo "<td><a href='javascript:void(0)' rel='{$post_id}' class='delete_link'>Delete</a></td>";

            
            // echo "<td><a onClick=\"javascript: confirm('Are you sure you want to delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
    } 
    
    ?>
</tbody>
</table> 
</form>

<script>

$(document).ready(function(){
    $(".delete_link").on('click', function(){
        var id = $(this).attr("rel");
        var delete_url = "posts.php?delete=" + id + " ";
        $(".modal_delete_link").attr("href", delete_url);
        $("#myModal").modal('show');
    });

});


</script>