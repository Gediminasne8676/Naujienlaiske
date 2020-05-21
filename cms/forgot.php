<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>



<?php 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require 'vendor\phpmailer\phpmailer\src\Exception.php';
// require 'vendor\phpmailer\phpmailer\src\PHPMailer.php';
// require 'vendor\phpmailer\phpmailer\src\SMTP.php';
require 'vendor\autoload.php';
// require 'Classes\config.php';
?>

<?php 

    if(!ifItIsMethod('get') && !isset($_GET['forgot'])){
        // redirect('index');
    }

    if(ifItIsMethod('post')){

        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $lenght = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($lenght));
            if(email_exists($email)){
                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?")){
                mysqli_stmt_bind_param($stmt, "s" ,$email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                // CONFIGURE PHPMailer
                // 
                // 
                // 
                // 
                $mail = new PHPMailer();
                echo get_class($mail);

                    //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = Config::SMTP_HOST;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = Config::SMTP_USER;                    // SMTP username
                $mail->Password   = Config::SMTP_PASSWORD;                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = Config::SMTP_PORT;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->isHTML(true);
                $mail->CharSet = "utf-8";

                $mail->setFrom('nenius.gedas@gmail.com', 'Gediminas');
                $mail->addAddress($email);

                // $mail->setFrom('from@example.com', 'Mailer');
                // $mail->addAddress('joe@example.net', 'Joe User'); 

                $mail->Subject = 'This is a test email';
                $mail->Body = '<p>
                <a href="http://localhost/cms/reset.php?token='.$token.' ">Please click this to reset your password</a>
                </p>';

                if($mail->send()){
                    echo "IT WAS SENT";
                    $emailSent = true;
                } else {
                    echo "IT WAS NOT SENT";
                }

                } else {
                    echo mysqli_stmt_error($stmt);
                    echo "WRONG";
                }
                
            }
        }

        // redirect('forgot.php');
    }

?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                        <?php if(!isset($emailSent)): ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        <?php else: ?>

                        <h2>Please check your email</h2>
                        
                        <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

