<?php 
if($_SESSION['user_role'] != 'admin'){
    header("Location: ../index.php");
}

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $commentValueId){
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options){
            case 'approved' :
            $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = '{$commentValueId}'";
            $update_to_published_status = mysqli_query($connection,$query);
            confirmQuery($update_to_published_status);
            break;

            case 'disapproved' :
            $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = '{$commentValueId}'";
            $update_status = mysqli_query($connection,$query);
            confirmQuery($update_status);
            break;

            case 'delete' :
            $query = "DELETE FROM comments WHERE comment_id = '{$commentValueId}'";
            $update_status = mysqli_query($connection,$query);
            confirmQuery($update_status);
            break;

            case 'clone' :
            $query = "SELECT * FROM comments WHERE comment_id = '{$commentValueId}'";
            $select_comment_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($select_comment_query)){

                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_content = $row['comment_content'];
                $comment_email = $row['comment_email'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
            }

            $query = "INSERT into comments( comment_post_id, comment_email, comment_content,";
            $query .=" comment_status, comment_author, comment_date) ";
            $query .="VALUES('{$comment_post_id}','{$comment_email}',";
            $query .="'{$comment_content}','{$comment_status}','{$comment_author}',now())";

            $clone_comment = mysqli_query($connection,$query);
            confirmQuery($clone_comment);
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
        <option value="approved">Approve</option>
        <option value="disapproved">Disapprove</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
        
    </select>
    <br>
</div>

<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply">
                    <thead>
                        <tr>
                        <th><input id="selectAllBoxes" type="checkbox"></th>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response to</th>
                            <th>Date</th>
                            <th>Approve</th>
                            <th>Disapprove</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
<?php
                        
if(isset($_GET['disapprove'])){
        $the_comment_id = $_GET['disapprove'];
        $query = "UPDATE comments SET comment_status = 'disapproved' where comment_id = {$the_comment_id}";
        $disapprove_comment_query = mysqli_query($connection,$query);
        confirmQuery($disapprove_comment_query);
        header("Location: comments.php");
}                        

if(isset($_GET['approve'])){
        $the_comment_id = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'approved' where comment_id = {$the_comment_id}";
        $approve_comment_query = mysqli_query($connection,$query);
        confirmQuery($approve_comment_query);
        header("Location: comments.php");
}              
  
if(isset($_GET['delete'])){
        $the_comment_id = $_GET['delete'];
    
        $query = "SELECT * FROM comments WHERE comment_id = {$the_comment_id}";
        $result = mysqli_query($connection,$query);
        confirmQuery($result);
        while ($row = mysqli_fetch_assoc($result)){
            $id = $row['comment_post_id'];
            $query = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
            $query .= "WHERE post_id = {$id}";
            $subtract_comment_count = mysqli_query($connection, $query);
            confirmQuery($subtract_comment_count);
        }
    
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
        $delete_query = mysqli_query($connection,$query);
        confirmQuery($delete_query);
//        header("Location: comments.php");
}
                        
?>
                          
                           
    <?php
    global $connection;
    $query = "SELECT * FROM comments";  
    $all_comments_query = mysqli_query($connection,$query);
    
    while($row = mysqli_fetch_assoc($all_comments_query))
    {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];

        echo "<tr>";
        ?><td><input class='checkBoxes' type='checkbox' name="checkBoxArray[]" value='<?php echo $comment_id ?>'></td><?php
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";
        
//            $query = "SELECT * FROM categories WHERE cat_id = {$post_category}";  
//            $select_categories_id = mysqli_query($connection,$query);
//            while($row = mysqli_fetch_assoc($select_categories_id))
//            {
//                $cat_id = $row['cat_id'];
//                $cat_title = $row['cat_title'];
//                echo "<td>{$cat_title}</td>";
//            }
//        
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";
        
            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
            $select_post_id_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_post_id_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?p_id={$post_id}'>Post Link</a></td>";
            }
        
        
            echo "<td>{$comment_date}</td>";
            echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
            echo "<td><a href='comments.php?disapprove={$comment_id}'>Disapprove</a></td>";
            echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
    } 
    
    ?>
</tbody>
</table> 