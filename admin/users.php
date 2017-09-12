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
                            Users
                            <small>Levi Gonzales</small>
                        </h1>
                        <?php 
                        if(isset($_GET['source'])){
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }
                        switch($source) {
                            case 'add_user';
                            include "includes/add_user.php";
                            break;

                            case 'edit_user';
                            include "includes/edit_user.php";
                            break;

                            case 'list_subs';
                            include "includes/view_all_subscribers.php";
                            break;

                            case 'list_admins';
                            include "includes/view_all_admins.php";
                            break;

                            default:
                            include "includes/view_all_users.php";
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