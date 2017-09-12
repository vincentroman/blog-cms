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
                            Categories
                            <small><?php echo $firstname .' '. $lastname; ?></small>
                        </h1>
                        <div class="col-xs-6">
                        <?php
                        // Add Category Query
                            if(isset($_POST['submit'])){
                                $cat_add = $_POST['cat_add'];
                                try{
                                    $insertCat = "INSERT INTO categories(cat_title) VALUES (:title)";
                                    $stm = $conn->prepare($insertCat);
                                    $stm->bindParam(":title", $cat_add);
                                    $stm->execute();
                                    header("Location: categories.php");
                                } catch(PDOException $ex){
                                    echo "Error: " . $ex->getMessage();
                                }
                            }
                        ?>
                            <!-- Add Categories -->
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_add">Add Category</label>
                                    <input class="form-control" type="text" name="cat_add">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>
                            </form>

                            <!-- Update Categories -->
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_update">Update Category</label>
                                    <?php
                                        // Captures the Id of the selected item and displays the value into the input feild. 
                                        if(isset($_GET['edit'])){
                                            $edit_id = $_GET['edit'];

                                            $valueQuery = "SELECT * FROM categories WHERE cat_id=:id";
                                            $vstm = $conn->prepare($valueQuery);
                                            $vstm->bindParam(":id", $edit_id);
                                            $vstm->execute();

                                            while($cat = $vstm->fetch(PDO::FETCH_OBJ)){ 
                                                $edit_id = $cat->cat_id;
                                                $edit_title = $cat->cat_title;
                                                ?>
                                                <input value="<?php if(isset($edit_title)){ echo $edit_title;} ?>" class="form-control" type="text" name="cat_update">
                                            <?php 
                                                echo "<div class='alert alert-info'><strong>Info!</strong> Change the above input in order to update your category.</div>";
                                            }
                                        }
                                        // Submits changed value from input feild
                                        if(isset($_POST['submitUpdate'])){
                                            $edit_update = $_POST['cat_update'];
                                            try{
                                                $updateQuery = "UPDATE categories SET cat_title=:title WHERE cat_id=:id";
                                                $ustm = $conn->prepare($updateQuery);
                                                $ustm->bindParam(":title", $edit_update);
                                                $ustm->bindParam(":id", $edit_id);
                                                $ustm->execute();
                                                header("Location: categories.php");
                                            }catch(PDOException $ex){
                                                echo "Error: " . $ex->getMessage();
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submitUpdate" value="Update Category">
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-6">
                                    <?php
                                    // Display Categories Query
                                        $catQuery = "SELECT * FROM categories";
                                        $statement = $conn->query($catQuery);
                                        $statement->execute();
                                        if(!$statement->rowCount() == 0){
                                            echo "<table class='table table-bordered table-hover'>
                                                    <thead>
                                                        <tr>
                                                            <th>Category Title</th>
                                                            <th>Delete Category</th>
                                                            <th>Edit Category</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                            while($cat = $statement->fetch(PDO::FETCH_OBJ)){
                                                $cat_id = $cat->cat_id;
                                                $cat_title = $cat->cat_title;
                                                echo "<tr>";
                                                echo "<td>$cat_title</td>";
                                                echo "<td><button class='btn btn-info'><a href='categories.php?edit=$cat_id' style='color:#fff;'>Edit</a></button></td>";
                                                echo "<td><button class='btn btn-danger'><a href='categories.php?delete=$cat_id' style='color:#fff;'>Delete</a></button></td>";
                                                echo "</tr>";
                                            }
                                        echo "</tbody>
                                            </table>";
                                        } else {
                                            echo "<h4 class='alert alert-info'>No current categories.</h4>";
                                        }

                                    // Delect Categories Query
                                     if(isset($_GET['delete'])){
                                        $cat_delete = htmlspecialchars($_GET['delete']);
                                        try{
                                            $deleteQuery = "DELETE FROM categories WHERE cat_id = :id";
                                            $dstm = $conn->prepare($deleteQuery);
                                            $dstm->bindParam(":id", $cat_delete);
                                            $dstm->execute();
                                            header("Location: categories.php");
                                        }catch(PDOException $ex){
                                            echo "Error: " . $ex->getMessage();
                                        }
                                     }
                                    ?>
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