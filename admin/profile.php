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
                            Profile
                        </h1>
                        <?php 
                        if(isset($_GET['source'])){
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }
                        switch($source) {

                            case 'edit_profile';
                            include "includes/edit_profile.php";
                            break;

                            case 'user_profile';
                            include 'includes/user_profile.php';
                            break;

                            default:
                            include "includes/view_profile.php";
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