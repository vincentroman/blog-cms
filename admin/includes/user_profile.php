<?php ob_start(); ?>
<?php 
if(isset($_GET['profile_id'])){ 
    $user_id = $_GET['profile_id'];
    //Show post information from databases to be edited
    try{
        $showUsersQuery = "SELECT * FROM users WHERE user_id=$user_id";
        $sustm = $conn->query($showUsersQuery);
        $sustm->execute();

      while($show = $sustm->fetch(PDO::FETCH_OBJ)){
        $show_username = $show->username;
        $show_firstname = $show->user_firstname;
        $show_lastname = $show->user_lastname;
        $show_role = $show->user_role;
        $show_email = $show->user_email;
        $show_img = $show->user_image;
      }
    }catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-2">
                        <img style="width:100%; border-radius: 50%;" src="def_img/<?php if(isset($show_img)){ echo $show_img; }else{ echo "card.jpg"; } ?>">
                    </div>
                    <div class="col-md-10">
                        <h4><?php if(isset($show_firstname) && isset($show_lastname)){ echo $show_firstname . ' ' . $show_lastname; }else{ echo "No Name"; } ?></h4>
                        <hr>
                        <p><strong>Username: </strong> <?php if(isset($show_username)){ echo $show_username; } else { echo "No Username"; } ?></p>
                        <p><strong>Role: </strong> <?php if(isset($show_role)){ echo $show_role; }else{ echo "No Role"; } ?></p>
                        <p><strong>Email: </strong> <?php if(isset($show_email)){ echo $show_email; }else{ echo "No Email"; } ?></p>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
</div>

<?php 
    $postsQuery = "SELECT * FROM posts WHERE post_author='$show_username'";
    $pstm = $conn->query($postsQuery);
    $pstm->execute();

    if(!$pstm->rowCount() == 0){
        $tableHeader = "<table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>";
            echo $tableHeader;
        while($post = $pstm->fetch(PDO::FETCH_OBJ)){
            $post_category_id = $post->post_category_id;
            $post_id = $post->post_id;
            $post_content = $post->post_content;
            echo "<tr>";
            echo "<td>$post_id</td>";
            echo "<td>$post->post_author</td>";
            echo "<td><a href='../post.php?p_id=$post_id'>$post->post_title</a></td>";

            // Category Query and Loop
            $valueQuery = "SELECT * FROM categories WHERE cat_id=:id";
            $vstm = $conn->prepare($valueQuery);
            $vstm->bindParam(":id", $post_category_id);
            $vstm->execute();

            while($cat = $vstm->fetch(PDO::FETCH_OBJ)){ 
                $cat_id = $cat->cat_id;
                $cat_title = $cat->cat_title;

                echo "<td>{$cat_title}</td>";
            }
            // end of Category Query and Loop

            echo "<td>$post->post_status</td>";

            if(strlen($post_content) > 200){
                echo "<td>" . substr($post_content, 0, 200) . " ...</td>";
            } else {
                echo "<td>" . $post_content . "</td>";
            }

            echo "<td><img style='width:150px;' src='img/$post->post_img'></td>";
            echo "<td>$post->post_tags</td>";

            // Comment Count Query and Loop
            $count_query = "SELECT COUNT(*) AS 'number' FROM comments WHERE comment_post_id=:num";
            $countstm = $conn->prepare($count_query);
            $countstm->bindParam(':num', $post_id);
            $countstm->execute();

            if(!$countstm->rowCount() == 0){
                while($num = $countstm->fetch(PDO::FETCH_OBJ)){
                    $num = $num->number;

                    echo "<td>$num</td>";
                }
            }
            // End of comment count query and loop

            echo "<td>$post->post_date</td>";
            echo "<td><button class='btn btn-danger'><a style='color:#fff;' href='profile.php?delete=$post->post_id'>Delete</a></button></td>";
            echo "<td><button class='btn btn-info'><a style='color:#fff;' href='posts.php?source=edit_post&p_id=$post->post_id'>Edit</a></button></td>";
            echo "</tr>";
        }
        $tableFooter = "    </tbody>
                        </table>";
        echo $tableFooter;
    } else {
        echo "<h4 class='alert alert-info'>User has not published any posts!</h4>";
    }
?>

<?php 
if(isset($_GET['delete'])){
 try{
    $postId = $_GET['delete'];
    $deletePostQuery = "DELETE FROM posts WHERE post_id=:id";
    $dpstm = $conn->prepare($deletePostQuery);
    $dpstm->bindParam(":id", $postId);
    $dpstm->execute();
    header("Location: profile.php");
 }catch(PDOException $ex){
    echo "Error: " . $ex->getMessage();
 }
}
?>








