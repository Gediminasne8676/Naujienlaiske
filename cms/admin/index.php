    <?php include "includes/admin_header.php"; ?>
    
<?php 



$post_counts = count_record(get_users_all_posts());

$comment_counts = count_record(get_users_all_comments());

$categories_counts = count_record(get_users_all_categories());

// $post_published_counts = 5;
// $post_draft_counts = 5;
// $unapproved_comment_count = 5;
// $approved_comment_count = 5;

$post_published_counts = count_record(get_users_all_published_posts());
$post_draft_counts = count_record(get_users_all_draft_posts());
$unapproved_comment_count = count_record(get_users_unapproved_comments());
$approved_comment_count = count_record(get_users_approved_comments());


?>


<div id="wrapper">

<?php 
//users online

?>

    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                
                <h1 class="page-header">
                Admin Page
                
                <small><?php echo $_SESSION['username'];?></small>
                </h1>
                
                </div>
            </div>
        <!-- /.row -->

               
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <?php echo "<div class='huge'>". $post_counts ."</div>";?>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php  
                     echo $comment_counts;

                     ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $users_counts = recordCount('users');?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div> -->
    <div class="col-lg-4 col-md-6">
    
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">


                        <div class='huge'><?php echo $categories_counts;?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->



            <div class="row">
            <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

<?php 
        $element_text = ['All Posts','Published Posts','Draft Posts' ,'Total Comments' ,'Approved Comments', 'Unapproved Comments', 'Categories'];
        $element_count = [$post_counts,$post_published_counts,$post_draft_counts,$comment_counts ,$approved_comment_count, $unapproved_comment_count, $categories_counts];

        for($i = 0; $i < 7; $i++){
            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
        }
?>


        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
     <div id="columnchart_material" style="width: 1100px; height: 500px;"></div>
            </div>

        </div>
    <!-- /.container-fluid -->

    </div>



    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>
    <script>console.log("test");</script>


    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>console.log("test");</script>



    <script>


    $(document).ready(function(){

        var pusher = new Pusher('cc9bfbd1b4329e3f729f', {

            cluster: 'eu',
            encrypted: true

        });

        var notificationChannel = pusher.subscribe('notifications');

        notificationChannel.bind('new_user', function(notification){
            var message = notification.message;
            toastr.success(`${message} just registered`);
            // console.log(message);
        });

    })



    </script>