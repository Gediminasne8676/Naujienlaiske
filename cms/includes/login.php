<?php include "db.php"?>
<?php include "../admin/functions.php"?>
<?php session_start();?>
<?php 

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    echo $username;
    echo $password;

    login_user($username, $password);
}





// if(isset($_POST['login'])){
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $username = mysqli_real_escape_string($connection, $username);
//     $password = mysqli_real_escape_string($connection, $password);
//     $password = password_hash($password, PASSWORD_BCRYPT, $options = array('cost' => 12));
    

// $query = "SELECT * FROM users WHERE username = '{$username}' ";
// $select_user_query = mysqli_query($connection, $query);
// if(!$select_user_query){
//     die("QUERY FAILED " . mysqli_error($connection));
// }
// }

// while($row = mysqli_fetch_array($select_user_query)){
//     $db_user_id = $row['user_id'];
//     $db_username = $row['username'];
//     $db_password = $row['password'];
//     $db_user_firstname = $row['user_firstname'];
//     $db_user_lastname = $row['user_lastname'];
//     $db_user_role = $row['user_role'];
    
// }

// $password = crypt($password, $db_password);

// if($username === $db_username && $password === $db_password){
//     $_SESSION['username'] = $db_username;
//     $_SESSION['firstname'] = $db_user_firstname;
//     $_SESSION['lastname'] = $db_user_lastname;
//     $_SESSION['user_role'] = $db_user_role;

//     header("Location: ../admin");
// } 
// else {
//     header("Location: ../index.php");
// }


?>