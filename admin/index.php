<?php include 'includes/admin_header.php'; ?>
    <div style="background: #263238;" id="wrapper">
<?php include 'includes/admin_nav.php'; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard
                            <small><?php if(isset($username)){ echo $username; } ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <?php 
                //Display posts related to the currently logged in user
                $num_of_posts = 'SELECT COUNT(*) AS num FROM posts WHERE post_author=:username';
                    $numstm = $conn->prepare($num_of_posts);
                    $numstm->bindParam(':username', $username);
                    $numstm->execute();

                    while($num = $numstm->fetch(PDO::FETCH_OBJ)){
                        $number_of_posts = $num->num;
                    }
                ?>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $number_of_posts; ?></div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Posts</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        // Shows the number of categories
                        $num_of_cats = 'SELECT COUNT(*) AS cat FROM categories';
                        $numcstm = $conn->query($num_of_cats);
                        $numcstm->execute();

                        while($cat_num = $numcstm->fetch(PDO::FETCH_OBJ)){
                            $number_of_cats = $cat_num->cat;
                        }
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-sitemap fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $number_of_cats; ?></div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Categories</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        // shows the number of subscribers
                        $num_of_subs = "SELECT COUNT(*) AS sub_num FROM subscribers";
                        $numsstm = $conn->query($num_of_subs);
                        $numsstm->execute();

                        while($sub_num = $numsstm->fetch(PDO::FETCH_OBJ)){
                            $number_of_subs = $sub_num->sub_num;
                        }
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $number_of_subs; ?></div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php?source=list_subs">
                                <div class="panel-footer">
                                    <span class="pull-left">View Subscribers</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        // shows the number of comments
                        $num_of_com = 'SELECT COUNT(*) AS com_num FROM comments';
                        $numComStm = $conn->query($num_of_com);
                        $numComStm->execute();

                        while($com_num = $numComStm->fetch(PDO::FETCH_OBJ)){
                            $number_of_comments = $com_num->com_num;
                        }
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $number_of_comments; ?></div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Comments</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-lg-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>Users List</h4>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                        <?php 
                                        // shows all profiles where the user_role = User
                                        $all_users_query = "SELECT * FROM users WHERE user_role='User'";
                                        $austm = $conn->query($all_users_query);
                                        $austm->execute();

                                        if(!$austm->rowCount() == 0){
                                            echo "<table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>Role</th>
                                                            <th>Profile</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                            while($all_users = $austm->fetch(PDO::FETCH_OBJ)){
                                                $userId = $all_users->user_id;
                                                $userFirstName = $all_users->user_firstname;
                                                $userLastName = $all_users->user_lastname;
                                                $userName = $all_users->username;
                                                $userRole = $all_users->user_role;
                                                $userEmail = $all_users->user_email;

                                                echo "<tr>
                                                        <td>$userFirstName</td>
                                                        <td>$userLastName</td>
                                                        <td>$userName</td>
                                                        <td>$userEmail</td>
                                                        <td>$userRole</td>
                                                        <td><a class='btn btn-default' href='profile.php?source=user_profile&profile_id=$userId'>View Profile</a></td>
                                                    </tr>";
                                            }
                                            echo "</tbody>
                                                </table>";    
                                        } else {
                                            echo "<h3 class='alert alert-info'><strong>Sorry!</strong> There are no current users. <a href='users.php?source=add_user'>Add A User</a></h3>";
                                        } 
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4><?php if(isset($firstname) && isset($lastname)){ echo $firstname . ' ' . $lastname; }else{ echo "No Name"; } ?></h4>
                                        <hr>
                                        <p><strong>Username: </strong> <?php if(isset($username)){ echo $username; } else { echo "No Username"; } ?></p>
                                        <p><strong>Role: </strong> <?php if(isset($role)){ echo $role; }else{ echo "No Role"; } ?></p>
                                        <p><strong>Email: </strong> <?php if(isset($email)){ echo $email; }else{ echo "No Email"; } ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <img style="width:100%; border-radius: 50%;" src="def_img/<?php if(isset($image)){ echo $image; }else{ echo "card.jpg"; } ?>">
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>Posts Still In Draft</h4>
                            </div>
                            <div class="panel-body">
                            <?php 
                            // show all posts that are still in draft
                            $all_draft_posts_query = "SELECT * FROM posts WHERE post_status='Draft'";
                            $adpstm = $conn->query($all_draft_posts_query);
                            $adpstm->execute();

                            if(!$adpstm->rowCount() == 0){
                                echo "<div class='table-responsive'>
                                    <table class='table'>
                                        <thead>
                                            <tr>
                                                <th>Author</th>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Edit Post</th>
                                                <th>Delete Post</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                while($all_drafts = $adpstm->fetch(PDO::FETCH_OBJ)){
                                    $post_Id = $all_drafts->post_id;
                                    $postAuthor = $all_drafts->post_author;
                                    $postTitle = $all_drafts->post_title;
                                    $postCon = $all_drafts->post_content;

                                    echo "<tr>";
                                    echo "<td>$postAuthor</td>";
                                    echo "<td>$postTitle</td>";
                                    echo "<td>" . substr($postCon, 0, 300) . "</td>";
                                    echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id=$post_Id'>Edit Post</a></td>";
                                    echo "<td><a class='btn btn-danger' href='index.php?delete=$post_Id'>Delete Post</a></td>";
                                    echo "</tr>";
                                    echo "</tbody>
                                                </table>
                                            </div>";
                                }
                            } else {
                                echo "<h3 class='alert alert-info'>No posts currently in draft.</h3>";
                            }

                            if(isset($_GET['delete'])){
                                $postId = $_GET['delete'];
                                $deletePostQuery = "DELETE FROM posts WHERE post_id=:id";
                                $dpstm = $conn->prepare($deletePostQuery);
                                $dpstm->bindParam(":id", $postId);
                                $dpstm->execute();
                                header("Location: index.php");
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>Comments Needing Action</h4>
                            </div>
                            <div class="panel-body">
                                <?php 
                                // shows all comments that have an unapproved status
                                $all_comments_query = "SELECT * FROM comments WHERE comment_status='Unapproved'";
                                $allComStm = $conn->query($all_comments_query);
                                $allComStm->execute();

                                if(!$allComStm->rowCount() == 0){
                                    echo "<div class='table-responsive'>
                                            <table class='table'>
                                                <thead>
                                                    <tr>
                                                        <th>Author</th>
                                                        <th>Content</th>
                                                        <th>Email</th>
                                                        <th>In Response To</th>
                                                        <th>Role</th>
                                                        <th>Approve</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                    while($all_comments = $allComStm->fetch(PDO::FETCH_OBJ)){
                                        $commentId = $all_comments->comment_id;
                                        $commentAuthor = $all_comments->comment_author;
                                        $commentContent = $all_comments->comment_content;
                                        $commenterEmail = $all_comments->comment_email;
                                        $commentResponse = $all_comments->response_to;

                                        echo "<tr>
                                                <td>$commentAuthor</td>
                                                <td>$commentContent</td>
                                                <td>$commenterEmail</td>
                                                <td>$commentResponse</td>
                                                <td>$userRole</td>
                                                <td><a class='btn btn-success' href='index.php?approve=$commentId'>Approve</a></td>
                                                <td><a class='btn btn-danger' href='index.php?delete=$commentId'>Delete</a></td>
                                            </tr>";
                                    }
                                    echo "</tbody>
                                        </table>
                                    </div>";
                                } else {
                                    echo "<h3 class='alert alert-info'>No comments currently needing action.</h3>";
                                }

                                //Delete Comment Query
                                if(isset($_GET['delete'])){
                                 try{
                                    $commentId = $_GET['delete'];
                                    $deleteComQuery = "DELETE FROM comments WHERE comment_id=:id";
                                    $dcstm = $conn->prepare($deleteComQuery);
                                    $dcstm->bindParam(":id", $commentId);
                                    $dcstm->execute();
                                    header("Location: index.php");
                                 }catch(PDOException $ex){
                                    echo "Error: " . $ex->getMessage();
                                 }
                                }

                                //Approve Comment Query
                                if(isset($_GET['approve'])){
                                    $commentId = $_GET['approve'];
                                    $approveComQuery = "UPDATE comments SET comment_status='Approved' WHERE comment_id=:id";
                                    $acstm = $conn->prepare($approveComQuery);
                                    $acstm->bindParam(":id", $commentId);
                                    $acstm->execute();
                                    header("Location: index.php");
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
<?php include 'includes/admin_footer.php'; ?>
