<?php include "includes/admin_header.php"; ?>

<?php 
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($select_user_profile_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}



if(isset($_POST['update_user']))
{
    $options = array('cost' => 11);

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    
//        $post_image = $_FILES['image']['name'];
//        $post_image_temp = $_FILES['image']['tmp_name'];
//        
    
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];

    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $renewpassword = $_POST['renewpassword'];


    if(password_needs_rehash($password, PASSWORD_BCRYPT, $options) && password_verify($password, PASSWORD_BCRYPT, $options)){
        $password = password_hash($password, PASSWORD_BCRYPT, $options);
    }
    if(!empty($oldpassword) && !empty($newpassword) && !empty($renewpassword)){
        $hashed_oldpassword = password_hash($oldpassword, PASSWORD_BCRYPT, $options);

        if(password_verify($oldpassword, $password)){
            if($newpassword == $renewpassword){
                $hashed_newpassword = password_hash($newpassword, PASSWORD_BCRYPT, $options);
                $query = "UPDATE users SET ";
                $query .="password = '{$hashed_newpassword}' ";
                $query .= "WHERE user_id = '{$user_id}'"; 
                $update_user_password = mysqli_query($connection, $query);
                confirmQuery($update_user_password);
                header("Refresh:0");
            }
            else{
                echo "<script>alert('Both new passwords have to match');</script>";
            }
        }
        else if($hashed_oldpassword != $password){
            echo "<script>alert('Old password is incorrect or empty');</script>";
        }
    }
    else if(!empty($oldpassword) || !empty($newpassword) || !empty($renewpassword)){
        echo "<script>alert('Some of passwords fiels are empty');</script>";
    }
    
//        $post_date = date('d-m-y');
    
//        move_uploaded_file($post_image_temp, "../images/$post_image");


          $query = "UPDATE users SET ";
        $query .="user_firstname = '{$user_firstname}', "; 
        $query .="user_lastname = '{$user_lastname}', ";
        $query .="user_role = '{$user_role}', ";
        $query .="username = '{$username}', ";
        $query .="user_email = '{$user_email}' ";
        $query .= "WHERE user_id = '{$user_id}'"; 
    $update_user = mysqli_query($connection, $query);
    confirmQuery($update_user);
}


?>

<div id="wrapper">

    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                
                <h1 class="page-header">
                Profile Page
                <small><?php echo $_SESSION['username']?></small>
                </h1>
                <form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
   <label for="title">Firstname</label>
   <input value="<?php echo $user_firstname ?>" type="text" class="form-control" name="user_firstname">
</div>

<div class="form-group">
   <label for="post_status">Lastname</label>
   <input value="<?php echo $user_lastname ?>" type="text" class="form-control" name="user_lastname">
</div>  

<label for="user_role">Role (this option will not exist here in release version)</label>
<select class="form-control" name="user_role" id="">
 <option value="<?php echo $user_role ?>"><?php echo $user_role?></option>
 <?php

   if($user_role == 'admin')
   {
       echo "<option value='subscriber'>subscriber</option>";
   }
   else
   {
       echo "<option value='admin'>admin</option>";
   }
          
   ?>
</select>

<!--
<div class="form-group">
   <label for="post_image">Post Image</label>
   <input type="file" name="image">
</div>
-->

<div class="form-group">
   <label for="post_tags">Username</label>
   <input value="<?php echo $username ?>" type="text" class="form-control" name="username">
</div>

<div class="form-group">
   <label for="post_content">Email</label>
   <input value="<?php echo $user_email ?>" type="email" class="form-control" name="user_email">
</div>

<div class="form-group">
   <label for="post_content">Old Password</label>
   <input value="" type="password" class="form-control" name="oldpassword">
</div>
<div class="form-group">
   <label for="post_content">New Password</label>
   <input value="" type="password" class="form-control" name="newpassword">
</div>
<div class="form-group">
   <label for="post_content">Repeat New Password</label>
   <input value="" type="password" class="form-control" name="renewpassword">
</div>


<div class="form-group">
   <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
</div>

</form>

                </div>
                
                
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>



    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>
