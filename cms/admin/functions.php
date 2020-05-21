<?php 

// DATABASE HELPER FUNCTIONS //

function redirect($location){
    header("Location:" . $location);
    exit;
}

function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }

    return false;
}

function query($query){

    global $connection;
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;

}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}

function count_record($result){
    return mysqli_num_rows($result);
}

// END DATABASE HELPERS //

// GENERAL HELPERS //

function get_user_name(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}




// GENERAL HELPERS END //

// AUTHENTICATOR HELPERS //


function is_admin($username){

    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id = ".$_SESSION['user_id']."");
        $row = fetchRecords($result);
        if($row['user_role'] == 'admin'){
            return true;
        } else {
            return false;
        }
    }

    return false;

}



// END AUTHENTICATOR HELPERS //

// USER SPECIFIC HELPERS //

function get_users_all_posts(){
    return query("SELECT * FROM posts WHERE user_id = ". loggedInUserId() ."");
}

function get_users_all_comments(){
    return query("
    SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()."
    ");
}

function get_users_all_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}

function get_users_all_published_posts(){
    return query("SELECT * FROM posts WHERE user_id =".loggedInUserId()." AND post_status='published'");
}

function get_users_all_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id =".loggedInUserId()." AND post_status='draft'");
}


function get_users_unapproved_comments(){
    return query("
    SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status='unapproved'
    ");
}

function get_users_approved_comments(){
    return query("
    SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status='approved'
    ");
}



// function get_username($user_id){
//     return fetchRecords(query("SELECT username FROM users WHERE user_id = '{$user_id}'"));
    
// }


// END USER SPECIFIC HELPERS //

function isLoggedIn(){
    if(isset($_SESSION['username'])){

        return true;

    }
    return false;

}


function loggedInUserId(){

    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username = '" . $_SESSION['username'] ."'");
        $users = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $users['user_id'] : die("loggedInUserId() failed : " . $connection);
    } else {
        return false;
    }
}

function userLikedThisPost($post_id){
    $result = query("SELECT * FROM likes WHERE user_id = " .loggedInUserId() . " AND post_id = {$post_id}");
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostLike($post_id){
    $result = query("SELECT * FROM likes WHERE post_id={$post_id}");
    confirmQuery($result);
    echo mysqli_num_rows($result);
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){

    if(isLoggedIn()){
        redirect($redirectLocation);
    }

}


function login_user($username, $password){
global $connection;

    if($username != null && $password != null){

        $result = mysqli_query($connection, "SELECT password FROM users WHERE username = '{$username}'");
        if(!$result){
                die("QUERY FAILEDd " . mysqli_error($connection));
            }
        
        // if(mysqli_num_rows($result) == 1){
            $hash = mysqli_fetch_array($result);
            $hash = $hash['password'];
            if(password_verify($password,$hash)){

                $query = "SELECT * FROM users WHERE username = '{$username}' ";
                $select_user_query = mysqli_query($connection, $query);
                if(!$select_user_query){
                    die("QUERY FAILED " . mysqli_error($connection));
                }
                
                while($row = mysqli_fetch_array($select_user_query)){
                    
                    $db_user_id = $row['user_id'];
                    $db_username = $row['username'];
                    $db_password = $row['password'];
                    $db_user_firstname = $row['user_firstname'];
                    $db_user_lastname = $row['user_lastname'];
                    $db_user_role = $row['user_role'];
                    
                }

                $_SESSION['user_id'] =  $db_user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;

            if($_SESSION['user_role'] == "admin"){
                header("Location: /cms/admin/");
            }
            else if($_SESSION['user_role'] == "subscriber"){
                header("Location: /cms/index.php");
            }
            
            } 
            else {
                return false;
            }

    }
}


function register_user($username, $email, $password){
    global $connection;
    
    $password = password_hash($password, PASSWORD_BCRYPT, $options = array('cost' => 11));

    $query = "INSERT into users (username, user_email, password, user_role)"; 
    $query .= "VALUES ('{$username}','{$email}','{$password}','subscriber')";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);
    echo "test";
    
}

function username_exists($username){
global $connection;

    $query = "SELECT username FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    }
    else {
        return false;
    }

}

function email_exists($email){
    global $connection;
    
        $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);
    
        if(mysqli_num_rows($result) > 0){
            return true;
        }
        else {
            return false;
        }
    
    }

function checkStatus($table, $column, $status){
    global $connection;

    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result); 

}

function recordCount($tablename){
    global $connection;
    $query = "SELECT * FROM " . $tablename;
    $select_all_post = mysqli_query($connection, $query);
    $post_counts = mysqli_num_rows($select_all_post); 
    return $post_counts;
}


function users_online(){
    if(isset($_GET['usersonline'])){
    global $connection;
        if(!$connection){
            session_start();
            include("../includes/db.php");
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 10;
            $time_out = $time - $time_out_in_seconds;
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);
            
                if($count == NULL){
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
                }
                else{
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}

users_online();

function confirmQuery($result){
    global $connection;
        if(!$result)
        {
            die("QUERY FAILED " . mysqli_error($connection));
        }
}

function getrandSalt(){
    global $connection;
    $query = "SELECT randSalt FROM users";
    $select_randSalt_query = mysqli_query($connection, $query);
    confirmQuery($select_randSalt_query);

    while($row = mysqli_fetch_array($select_randSalt_query))
    {
        if(!empty($row['randSalt'])){
            $randSalt = $row['randSalt'];
            break;
        }
    }
    return $randSalt;
}

function insert_categories(){
    global $connection;
    if(isset($_POST['submit']))
                     {
                         $cat_title = $_POST['cat_title'];
                         if($cat_title == "" || empty($cat_title))
                         {
                             echo "Please insert Category name";
                         }
                         else
                         {
                             $stmt = $query = mysqli_prepare($connection,"INSERT into categories(cat_title) VALUE(?) ");
                            //  $create_category_query = mysqli_query($connection, $query);
                            
                            mysqli_stmt_bind_param($stmt, 's', $cat_title);
                            mysqli_stmt_execute($stmt);
                            
                             if(!$stmt)
                             {
                                 die('QUERY FAILED ' . mysqli_error($connection));
                             }
                             mysqli_stmt_close($stmt);
                         }
                          
                     }
}

function findeAllCategories(){
    global $connection;
                            
                        $query = "SELECT * FROM categories";  
                        $all_categories_query_sidebar = mysqli_query($connection,$query);
                        while($row = mysqli_fetch_assoc($all_categories_query_sidebar))
                            {
                            echo "<tr>";
                            echo "<td>{$row['cat_id']}</td>";
                            echo "<td>{$row['cat_title']}</td>"; 
                            echo "<td><a href='categories.php?delete={$row['cat_id']}'>Delete</a></td>";
                            echo "<td><a href='categories.php?edit={$row['cat_id']}'>Edit</a></td>";
                            echo "</tr>";

                            } 
    
    
}

function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])){
                            
                        $the_cat_id = $_GET['delete'];
                            
                        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";  
                        mysqli_query($connection,$query);
                            header("Location: categories.php");
                        }
}

?>