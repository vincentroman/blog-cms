<?php ob_start(); ?>
<?php include 'includes/admin_header.php'; ?>
    <div style="background: #263238;" id="wrapper">
<?php include 'includes/admin_nav.php'; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts
                            <small>
                            <?php 
                                if(isset($firstname) || isset($lastname)){
                                    echo $firstname .' '. $lastname; 
                                } else {
                                    echo "John Doe";
                                }
                            ?>         
                            </small>
                        </h1>
                        <?php 
                        if(isset($_GET['source'])){
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }
                        switch($source) {
                            case 'add_post';
                            include "includes/add_post.php";
                            break;

                            case 'edit_post';
                            include "includes/edit_post.php";
                            break;

                            default:
                            include "includes/view_all_posts.php";
                            break;
                        }
                        ?>
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