        <!-- Navigation -->
        <nav style="background: #263238;" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
                <a class="navbar-brand" href="../index.php">Home Page</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
            <!-- Drop down  -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo 'Hello, '.$firstname.' '.$lastname ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->


            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul style="background: #263238;" class="nav navbar-nav side-nav">
                <?php 
                if($role === 'Admin'){
                    $dashboard = "
                    <li>
                        <a href='index.php'><i class='fa fa-fw fa-dashboard'></i> Dashboard</a>
                    </li>";
                    echo $dashboard;
                }
                ?>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#post_dropdown"><i class="fa fa-fw fa-file-text-o"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="post_dropdown" class="collapse">
                            <li>
                                <a href="posts.php"><i class="fa fa-fw fa-eye"></i> View All Posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post"><i class="fa fa-fw fa-pencil"></i> Add New Posts</a>
                            </li>
                            <!-- <li>
                                <a href="posts.php?source=edit_post">Edit Posts</a> 
                            </li> -->
                        </ul>
                    </li>
                    <li>
                        <a href="categories.php"><i class="fa fa-fw fa-sitemap"></i> Categories</a>
                    </li>
                    <?php
                    if($role === 'Admin'){ 
                        $comments_link = "<li>
                            <a href='comments.php'><i class='fa fa-fw fa-comments'></i> Comments</a>
                        </li>";
                        echo $comments_link;
                    }
                    ?>
                    <li>
                        <a href="media.php"><i class="fa fa-fw fa-picture-o"></i> Media</a>
                    </li>
                    <?php 
                            if($role === 'Admin'){
                                $users_link = "<li>
                        <a href='javascript:;' data-toggle='collapse' data-target='#categories'><i class='fa fa-fw fa-users'></i> Users <i class='fa fa-fw fa-caret-down'></i></a>
                        <ul id='categories' class='collapse'>
                            <li>
                                <a href='users.php?source=list_admins'><i class='fa fa-fw fa-eye'></i> View All Admins</a>
                            </li>
                            <li>
                                <a href='users.php'><i class='fa fa-fw fa-eye'></i> View All Users</a>
                            </li>
                            <li>
                                <a href='users.php?source=list_subs'><i class='fa fa-fw fa-eye'></i> View All Subscribers</a>
                            </li>
                            <li>
                                <a href='users.php?source=add_user'><i class='fa fa-fw fa-plus'></i> Add User</a>
                            </li>
                            <!-- <li>
                                <a href='users.php?source=edit_user'>Edit Users</a>
                                ****** enable if page needs to be accessable ******
                            </li> -->
                        </ul>
                    </li>";
                                echo $users_link;
                            }
                            ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>