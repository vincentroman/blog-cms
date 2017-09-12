<?php 
require 'bootstrap.php';
include 'includes/header.php';
?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- Error Message -->
                <div class='alert alert-info'>
                    <h1 class='text-center'><strong>Sorry!</strong></h1>
                    <h3 class='text-center'>There are currently no posts related to this category.<h3>
                </div>
                <!-- Blog Post -->
                <div id="category_blog_posts"></div>
            </div><!-- / blog entries column -->
            <?php include 'includes/sidebar.php'; ?>
        </div>
        <!-- /.row -->
        <hr>
 <?php include 'includes/footer.php'; ?>