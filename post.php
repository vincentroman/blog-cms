<?php 
require 'bootstrap.php';
include 'includes/header.php';
?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div style="background: #EDEDED; border-radius: 10px;" class="col-md-8">
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- Blog Post -->
                <?php 
                if(isset($_GET['p_id'])){
                    $postid = $_GET['p_id'];
                    try{
                    $postQuery = "SELECT * FROM posts WHERE post_id=:id";
                    $statement = $conn->prepare($postQuery);
                    $statement->bindParam(":id", $postid);
                    $statement->execute();
                        while($post = $statement->fetch(PDO::FETCH_OBJ)){
                            $post_title = $post->post_title;
                            $output = "<h2>$post_title</h2>
                            <img class=\"img-responsive\" src='admin/img/$post->post_img' alt=\"$post->post_img_alt\">
                            <hr>
                            <p class=\"lead\">
                                by <a href=\"index.php\">$post->post_author</a>
                            </p>
                            <p><span class=\"glyphicon glyphicon-time\"></span> Posted on $post->post_date</p>
                            <p><strong>Tags: </strong>$post->post_tags</p>
                            <hr>
                            <p>$post->post_content</p>

                            <hr style='border: 1px solid grey;'>";
                            echo $output;
                        }
                    $statement = null;
                    $postQuery = null;
                    } catch(PDOException $ex){
                        echo "An error occured" . $ex->getMessage();
                    }
                }
                ?>
                <!-- Blog Comments -->
                <!-- Comments Form -->
                <div class="well">
                <?php 
                if(isset($_POST['submit-comment'])){
                    $p_id = $_GET['p_id'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $content = $_POST['content'];
                    $date = date('y-m-d');
                    try{
                        $commentQuery = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_date, response_to) VALUES(:pid, :name, :email, :content, :comdate, :response)";
                        $cqstm = $conn->prepare($commentQuery);
                        $cqstm->bindParam(':pid', $p_id);
                        $cqstm->bindParam(':name', $name);
                        $cqstm->bindParam(':email', $email);
                        $cqstm->bindParam(':content', $content);
                        $cqstm->bindParam(':comdate', $date);
                        /*
                        Another option is to user the $_GET['p_id'] to query the posts table again in order to pull the post_title.
                        This would be nessesary if we closed the connection on the select query above.
                        */
                        $cqstm->bindParam(':response', $post_title);
                        $cqstm->execute();
                        $cqstm = null;
                        $commentQuery = null;
                    }catch(PDOException $ex){
                        echo "Error: " . $ex->getMessage();
                    }
                }
                ?>
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div>
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name">
                        </div>
                        <br>
                        <div>
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" name="email">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="content">Comment:</label>
                            <textarea class="form-control" name="content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit-comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>
                <!-- Posted Comments -->
                <?php 
                if(isset($_GET['p_id'])){
                    $p_id = $_GET['p_id'];
                    try{
                        $display_comments_query = "SELECT * FROM comments WHERE comment_post_id=:id AND comment_status='Approved'";
                        $dcstm = $conn->prepare($display_comments_query);
                        $dcstm->bindParam(':id', $p_id);
                        $dcstm->execute();

                        if(!$dcstm->rowCount() == 0){
                            while($com = $dcstm->fetch(PDO::FETCH_OBJ)){
                                include 'partials/comments.view.php';
                            }
                        } else {
                            echo "<h4 class='alert'>Be the first to leave a comment!</h4>";
                        }
                    }catch(PDOException $ex){
                        echo "Error: " . $ex->getMessage();
                    }
                }
                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div><!-- end of .media-body -->
                </div><!-- end of .media -->
            </div>
            <!-- / blog entries column -->
            <?php include 'includes/sidebar.php'; ?>
        </div>
        <!-- /.row -->
        <hr>
 <?php include 'includes/footer.php'; ?>