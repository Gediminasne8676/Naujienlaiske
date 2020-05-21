<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

    <!-- Navigation -->
    
<?php  include "includes/navigation.php"; ?>
 <?php 
 if(isset($_POST['submit'])){
    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['content'])){
        $username = mysqli_real_escape_string($connection ,$_POST['username']);
        $email = mysqli_real_escape_string($connection ,$_POST['email']);
        $content = mysqli_real_escape_string($connection ,$_POST['content']);

        $to      = 'nenius.gedas@gmail.com';
        $subject = $email;
        $message = $content;
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $message, $headers);


    }
    else{
        echo "<script>alert('All fields cannot be empty!');</script>";
    }
 }
 ?>


    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">

                        <div class="form-group">
                            <label for="name" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Name">
                        </div>

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>

                        <div class="form-group">
                        <label for="post_content" class="sr-only">Post Content</label>
                        <textarea class="form-control" name="content" id="editor" cols="30" rows="10" placeholder="Some text.."></textarea>
                        </div>  
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send email">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
