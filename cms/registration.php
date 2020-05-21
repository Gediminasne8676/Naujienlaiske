<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

    <!-- Navigation -->
    
<?php  include "includes/navigation.php"; ?>

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php 


// require 'vendor/autoload.php';


// // Setting Language Variables
if(isset($_GET['lang']) && !empty($_GET['lang'])){

    $_SESSION['lang'] = $_GET['lang'];

    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
        echo "<script type='text/javascript'>location.reload()</script>";
    }
}

    if(isset($_SESSION['lang'])){
        include "includes/languages/" . $_SESSION['lang'] . ".php";
    } else {
        include "includes/languages/en.php";
    }


// //SENDING EMAIL PUSHER
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// $options = array(
//     'cluster' => 'eu',
//     'useTLS' => true
//   );
//   $pusher = new Pusher\Pusher(
//     getenv('APP_KEY'),
//     getenv('APP_SECRET'),
//     getenv('APP_ID'),
//     $options
//   );

  
//   $data['message'] = 'hello world';
//   $pusher->trigger('my-channel', 'my-event', $data);
  
// ?>


 <?php 
 if(isset($_POST['submit'])){
    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])){
        $username = mysqli_real_escape_string($connection ,$_POST['username']);
        $email = mysqli_real_escape_string($connection ,$_POST['email']);
        $password = mysqli_real_escape_string($connection ,$_POST['password']);

        $error = [
            'username' => '',
            'email' => '',
            'password' => ''
        ];

        if(strlen($username) < 2){
            $error['username'] = 'Username needs to be longer';
        }
        if($username == ''){
            $error['username'] = 'Username field cannot be empty!';
        }
        if(username_exists($username)){
            $error['username'] = 'Username already exists, pick another one';
        }
    
        if(strlen($email) < 2){
            $error['email'] = 'Email needs to be longer';
        }
        if($email == ''){
            $error['email'] = 'Email field cannot be empty!';
        }
        if(email_exists($email)){
            $error['email'] = 'Email already exists, pick another one';
        }
    
        if(strlen($password) < 2){
            $error['password'] = 'Password is too short!';
        }

        foreach($error as $key => $value){
            if(empty($value)){
                unset($error[$key]);
            }
        }

        if(empty($error)){
            register_user($username, $email, $password);
            $data['message'] = $username;
            $pusher->trigger('notifications','new_user', $data);
        }
        else{
            echo "hahah" . $error['username'] . $error['password'] . $error['email'];
        }
        
    }
    // else{
    //     echo "<script>alert('All fields cannot be empty!');</script>";
    // }
 }
 ?>


    <!-- Page Content -->
    <div class="container">
    
    <form method="get" class="navbar-form navbar-right" action="" id="language_form">
        <div class="form-group">
            <select name="lang" class="form-control" id="" onchange="changeLanguage()" >
                <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){echo "selected"; }?>>English</option>
                <option value="lt" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'lt'){echo "selected"; }?>>Lietuviškai</option>
            </select>
        </div>
    </form>


<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER;?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME?>">
                        
                            <p><?php if(isset($error['username'])) {echo $error['username'];}?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL?>">

                            <p><?php if(isset($error['email'])) {echo $error['email'];}?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD?>">

                            <p><?php if(isset($error['password'])) {echo $error['password'];}?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>

        <script>
        
        function changeLanguage(){
            document.getElementById('language_form').submit();

        }

        </script>



<?php include "includes/footer.php";?>
