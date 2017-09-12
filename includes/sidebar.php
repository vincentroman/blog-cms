<?php 
ob_start();
date_default_timezone_set('America/Los_Angeles');
include_once 'db.php'; 
?>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form id="blogSearch" action="" method="post">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button id="blogSearchSubmit" class="btn btn-default" name="submit-search" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <?php 
                    echo "<br>";
                    ?>
                    <div class="list-group">
                    <?php
                        /*
                        Update comment:
                        In the future, this should be an ajax form using a get request.
                        */
                        if(isset($_POST['submit-search'])){
                            $search =  $_POST['search'];
                            try{
                                $searchQuery = "SELECT * FROM posts WHERE post_tags LIKE CONCAT('%', :tag, '%')";
                                $scstm = $conn->prepare($searchQuery);
                                $scstm->bindParam(":tag", $search);
                                $scstm->execute();

                                if(!$scstm->rowCount() == 0){
                                    while($tags = $scstm->fetch(PDO::FETCH_OBJ)){
                                        $result = "<a href=\"post.php?p_id=$tags->post_id\" class='list-group-item'>$tags->post_title</a>";
                                        echo $result;
                                    }
                                } else {
                                    echo "<a href=\"#\" class='list-group-item list-group-item-danger'>No Results</a>";
                                }
                            }catch(PDOException $ex){
                                echo "An error has occured" . $ex->getMessage();
                            }
                        }
                    ?>
                    </div>
                    <!-- /.input-group -->
                </div>
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-sm-6 col-md-12 col-lg-12">
                            <?php 
                            try{
                                $catReady = "SELECT * FROM categories";
                                $sccstm = $conn->query($catReady);
                                if(!$sccstm->rowCount() == 0){
                                    while($cat = $sccstm->fetch(PDO::FETCH_OBJ)){
                                        $output = "<span style=\"margin-right: 5px; margin-left: 5px;\"><a href=\"category.php?category=$cat->cat_id\">$cat->cat_title</a></span> / ";
                                        echo $output;
                                    }
                                } else {
                                    echo "<h5 class='alert alert-info'>No current categories.</h5>";
                                }

                            }catch(PDOException $ex) {
                                echo "An error occured" . $ex->getMessage();
                            }
                            ?>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                    <?php 
                        if(isset($_POST['sub_submit'])){

                            $uname = $_POST['sub_name'];
                            $email = $_POST['sub_email'];
                            $pword = $_POST['sub_password'];

                            try{
                                $regSub = "INSERT INTO subscribers(sub_username, sub_email, sub_password) 
                                VALUES(:uname, :email, :password)";
                                $rsstm = $conn->prepare($regSub);
                                $rsstm->bindParam(':uname', $uname);
                                $rsstm->bindParam(':email', $email);
                                $rsstm->bindParam(':password', password_hash($pword, PASSWORD_BCRYPT));
                                $rsstm->execute();
                                header("Location: index.php");
                            }catch(PDOException $ex){
                                echo "Error: " . $ex->getMessage();
                            }       
                        }
                    ?>
                <!-- Subscribe -->
                <div class="well">
                    <h4>Subscribe Here</h4>
                    <div class="row">
                        <div class="col-sm-6 col-md-12 col-lg-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="sub_name">Username</label>
                                    <input class="form-control" type="text" name="sub_name" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="sub_email">Email</label>
                                    <input class="form-control" type="email" name="sub_email" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="sub_password">Password</label>
                                    <input class="form-control" type="password" name="sub_password" autocomplete="off">
                                </div>
                                <input class="btn btn-primary" type="submit" name="sub_submit" value="Subscribe">
                            </form>
                        </div>
                    </div>
                </div>
                <?php include 'includes/widget.php'; ?>
            </div>