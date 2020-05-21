<?php include "includes/admin_header.php" ?>

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
                
                <small><?php echo strtoupper(get_user_name());?></small>
                </h1>
                
                </div>
            </div>
        <!-- /.row -->

               
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $post_counts = recordCount('posts');?></div>
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
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $comment_counts = recordCount('comments');?></div>
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
    <div class="col-lg-3 col-md-6">
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
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">


                        <div class='huge'><?php echo $categories_counts = recordCount('categories');?></div>
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


                <?php 

                $post_published_counts = checkStatus('posts', 'post_status', 'published');

                $post_draft_counts = checkStatus('posts', 'post_status', 'draft');

                $unapproved_comment_count = checkStatus('comments', 'comment_status', 'unapproved');

                $approved_comment_count = checkStatus('comments', 'comment_status', 'approved');

                $subscribers_count = checkStatus('users', 'user_role', 'subscriber');

                ?>

            <div class="row">
            <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

<?php 
        $element_text = ['All Posts','Published Posts','Draft Posts' ,'Pending Comments' ,'Comments', 'Users', 'Subscribers', 'Categories'];
        $element_count = [$post_counts,$post_published_counts , $post_draft_counts,$unapproved_comment_count ,$comment_counts, $users_counts, $subscribers_count, $categories_counts];

        for($i = 0; $i < 8; $i++){
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