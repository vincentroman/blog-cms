<?php ob_start(); ?>
<h3>Approved Comments</h3>
        <?php 
            $comAQuery = "SELECT * FROM comments WHERE comment_status='Approved'";
            $castm = $conn->query($comAQuery);
            $castm->execute();

            if(!$castm->rowCount() == 0){
                $table_header_one = "<table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response To</th>
                            <th>Date</th>
                            <th>Unapprove</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>";
                    echo $table_header_one;
                while($coma = $castm->fetch(PDO::FETCH_OBJ)){
                    $comment_id = $coma->comment_id;
                    echo "<tr>";
                    echo "<td>$coma->comment_id</td>";
                    echo "<td>$coma->comment_author</td>";
                    echo "<td>$coma->comment_content</td>";
                    echo "<td>$coma->comment_email</td>";
                    echo "<td>$coma->comment_status</td>";
                    echo "<td><a href='../post.php?p_id=$coma->comment_post_id'>$coma->response_to</a></td>";
                    echo "<td>$coma->comment_date</td>";
                    echo "<td><button class='btn btn-warning'><a style='color:#fff;' href='comments.php?unapprove=$comment_id'>Unapprove</a></button></td>";
                    echo "<td><button class='btn btn-info'><a style='color:#fff;' href='comments.php?source=edit_post&p_id=$comment_id'>Edit</a></button></td>";
                    echo "<td><button class='btn btn-danger'><a style='color:#fff;' href='comments.php?delete=$comment_id'>Delete</a></button></td>";
                    echo "</tr>";
                    $table_footer_one = "</tbody>
                                    </table>";
                    echo $table_footer_one;
                }
            } else {
                echo "<h3 class='alert alert-info'>No approved comments.</h3>";
            }
        ?>
<!-- Unapproved Comments -->
<hr>
<h3>Unapproved Comments</h3>
        <?php 
            $comQuery = "SELECT * FROM comments WHERE comment_status='Unapproved'";
            $cstm = $conn->query($comQuery);
            $cstm->execute();

            if(!$cstm->rowCount() == 0){
                $table_header_two = "<table class='table table-bordered table-hover'>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In Response To</th>
                            <th>Date</th>
                            <th>Approve</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>";
                    echo $table_header_two;
                while($com = $cstm->fetch(PDO::FETCH_OBJ)){
                    $comment_id = $com->comment_id;
                    echo "<tr>";
                    echo "<td>$com->comment_id</td>";
                    echo "<td>$com->comment_author</td>";
                    echo "<td>$com->comment_content</td>";
                    echo "<td>$com->comment_email</td>";
                    echo "<td>$com->comment_status</td>";
                    echo "<td><a href='../post.php?p_id=$com->comment_post_id'>$com->response_to</a></td>";
                    echo "<td>$com->comment_date</td>";
                    echo "<td><button class='btn btn-success'><a style='color:#fff;' href='comments.php?approve=$comment_id'>Approve</a></button></td>";
                    echo "<td><button class='btn btn-info'><a style='color:#fff;' href='comments.php?source=edit_post&p_id=$comment_id'>Edit</a></button></td>";
                    echo "<td><button class='btn btn-danger'><a style='color:#fff;' href='comments.php?delete=$comment_id'>Delete</a></button></td>";
                    echo "</tr>";
                    $table_footer_two = "</tbody>
                                    </table>";
                    echo $table_footer_two;
                }
            } else {
                echo "<h3 class='alert alert-info'>No Unapproved comments.</h3>";
            }
        ?>
<?php 
//Delete Comment Query
if(isset($_GET['delete'])){
 try{
    $commentId = $_GET['delete'];
    $deleteComQuery = "DELETE FROM comments WHERE comment_id=:id";
    $dcstm = $conn->prepare($deleteComQuery);
    $dcstm->bindParam(":id", $commentId);
    $dcstm->execute();
    header("Location: comments.php");
 }catch(PDOException $ex){
    echo "Error: " . $ex->getMessage();
 }
}

//Approve Comment Query
if(isset($_GET['approve'])){
 try{
    $commentId = $_GET['approve'];
    $approveComQuery = "UPDATE comments SET comment_status='Approved' WHERE comment_id=:id";
    $acstm = $conn->prepare($approveComQuery);
    $acstm->bindParam(":id", $commentId);
    $acstm->execute();
    header("Location: comments.php");
 }catch(PDOException $ex){
    echo "Error: " . $ex->getMessage();
 }
}

//Unapprove Comment Query
if(isset($_GET['unapprove'])){
 try{
    $commentId = $_GET['unapprove'];
    $unapproveComQuery = "UPDATE comments SET comment_status='Unapproved' WHERE comment_id=:id";
    $uacstm = $conn->prepare($unapproveComQuery);
    $uacstm->bindParam(":id", $commentId);
    $uacstm->execute();
    header("Location: comments.php");
 }catch(PDOException $ex){
    echo "Error: " . $ex->getMessage();
 }
}
?>








