


    <nav class="navbar navbar-inverse navbar-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms/index">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav"> <?php
                $query = "SELECT * FROM categories";  
                    $all_categories_query = mysqli_query($connection,$query);
                    while($row = mysqli_fetch_assoc($all_categories_query))
                    {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                    
                        $category_class = '';
                        $pageName = basename($_SERVER['PHP_SELF']);

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                            $category_class = 'active';
                        } 
                        echo "<li class='{$category_class}'> <a href='/cms/category/{$row['cat_id']}'>{$row['cat_title']}</a></li>";
                        
                    }
                    ?>

                    <?php 
                    if(isLoggedIn()):
                    ?>

                        <li>
                            <a href="admin/profile.php">Profile panel</a>
                        </li>
                    
                    <?php else: ?>


                    
                    <?php endif; ?>

                    
                    <?php  
                        if(isset($_SESSION['user_role']))
                        {
                            if(isset($_GET['p_id'])){
                                $the_post_id = $_GET['p_id'];
                                echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                            }
                        }
                    ?>

                </ul>
                    <ul class="nav navbar-nav navbar-right" style="margin-right: 5px;">
                        <li>
                        <?php
                        if(isset($_SESSION['user_role']))
                        {
                            if($_SESSION['user_role'] == 'admin')
                            {
                                echo "<li class='nav navbar-right'><a href='/cms/admin/'>Admin panel</a></li>";
                            }
                        }
                        ?>
                        </li>
                    </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
