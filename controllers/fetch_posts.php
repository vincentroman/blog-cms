<?php 

// Fetch Posts Right Away
// if somthing is set like a get requests, then show all the blog posts 
try{
$postQuery = "SELECT * FROM posts WHERE post_status='Published' LIMIT 10";
$statement = $conn->query($postQuery);
if(!$statement->rowCount() == 0){
    while($post = $statement->fetch(PDO::FETCH_OBJ)){
        $post_id = $post->post_id;
        $post_content = substr($post->post_content, 0, 1000);
        include 'partials/post.view.php';
    }
} else {
    echo "<h3 class='alert alert-info'><stronge>Sorry! </stronge>there is currently no content. Please come back later.</h3>";
}
} catch(PDOException $ex){
    echo "An error occured" . $ex->getMessage();
}


// Fetch posts by category
if(isset($_GET['category'])){
    $post_cat = $_GET['category'];
    
    try{
    $postQuery = "SELECT * FROM posts WHERE post_category_id=:id";
    $statement = $conn->prepare($postQuery);
    $statement->bindParam(":id", $post_cat);
    $statement->execute();
        if(!$statement->rowCount() == 0){
            while($post = $statement->fetch(PDO::FETCH_OBJ)){
                $post_id = $post->post_id;
                $post_content = substr($post->post_content, 0, 1000);
                include 'partials/post.view.php';
            }
        } else {
            echo "";
        }
    } catch(PDOException $ex){
        echo "An error occured" . $ex->getMessage();
    }
}
