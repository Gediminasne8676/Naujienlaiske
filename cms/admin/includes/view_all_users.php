 
 
 


<?php 
if($_SESSION['user_role'] != 'admin'){
    header("Location: ../index.php");
}

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $userValueId){
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options){
            case 'admin' :
            $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = '{$userValueId}'";
            $update_role = mysqli_query($connection,$query);
            confirmQuery($update_role);
            break;

            case 'subscriber' :
            $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = '{$userValueId}'";
            $update_role = mysqli_query($connection,$query);
            confirmQuery($update_role);
            break;

            case 'delete' :
            $query = "DELETE FROM users WHERE user_id = '{$userValueId}'";
            $delete_users = mysqli_query($connection,$query);
            confirmQuery($delete_users);
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
        <option value="admin">Make To Admin</option>
        <option value="subscriber">Make To Subscriber</option>
        <option value="delete">Delete User</option>
        
    </select>
    <br>
</div>

<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply">
<a class="btn btn-primary" href="users.php?source=add_user">Add New</a>
                    <thead>
                        <tr>
                            <th><input id="selectAllBoxes" type="checkbox"></th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Make to Admin</th>
                            <th>Make to Sub</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
<?php
                        
if(isset($_GET['change_to_admin'])){
        $the_user_id = $_GET['change_to_admin'];
        $query = "UPDATE users SET user_role = 'admin' where user_id = {$the_user_id}";
        $user_admin_query = mysqli_query($connection,$query);
        confirmQuery($user_admin_query);
        header("Location: users.php");
}                        

if(isset($_GET['change_to_sub'])){
        $the_user_id = $_GET['change_to_sub'];
        $query = "UPDATE users SET user_role = 'subscriber' where user_id = {$the_user_id}";
        $user_subscriber_query = mysqli_query($connection,$query);
        confirmQuery($user_subscriber_query);
        header("Location: users.php");
}             
  
if(isset($_GET['delete'])){
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] == "admin"){
            $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
            $delete_query = mysqli_query($connection,$query);
            confirmQuery($delete_query);
            header("Location: users.php");
        }
    }  
}
                        
?>
                          
                           
    <?php
    global $connection;
    $query = "SELECT * FROM users";  
    $all_users_query = mysqli_query($connection,$query);
    
    while($row = mysqli_fetch_assoc($all_users_query))
    {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];

        echo "<tr>";
        ?><td><input class='checkBoxes' type='checkbox' name="checkBoxArray[]" value='<?php echo $user_id ?>'></td><?php
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
        
//            $query = "SELECT * FROM categories WHERE cat_id = {$post_category}";  
//            $select_categories_id = mysqli_query($connection,$query);
//            while($row = mysqli_fetch_assoc($select_categories_id))
//            {
//                $cat_id = $row['cat_id'];
//                $cat_title = $row['cat_title'];
//                echo "<td>{$cat_title}</td>";
//            }
//        
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
        
//            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
//            $select_post_id_query = mysqli_query($connection, $query);
//            while($row = mysqli_fetch_assoc($select_post_id_query)){
//                $post_id = $row['post_id'];
//                $post_title = $row['post_title'];
//                echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
//            }
//        
        
            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
            echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
    } 
    
    ?>
</tbody>
</table> 