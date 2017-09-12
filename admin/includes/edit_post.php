<?php
if(isset($_GET['p_id'])){ 
	$edit_post_id = $_GET['p_id'];
	//Show post information from databases to be edited
	try{
		$showPostsQuery = "SELECT * FROM posts WHERE post_id=$edit_post_id";
	  $spstm = $conn->query($showPostsQuery);
	  $spstm->execute();

	  while($show = $spstm->fetch(PDO::FETCH_OBJ)){
	  	$show_title = $show->post_title;
	  	$show_post_cat_id = $show->post_category_id;
	  	$show_author = $show->post_author;
	  	$show_tags = $show->post_tags;
	  	$show_status = $show->post_status;
	  	$show_img = $show->post_img;
	  	$show_content = $show->post_content;
	  }
	}catch(PDOException $ex){
		echo "Error: " . $ex->getMessage();
	}
}
// Submits changed value from input feild
if(isset($_POST['edit_post'])){
    $edit_update_id = $_GET['p_id'];
    $edit_title = $_POST['title'];
    $edit_post_cat_id = $_POST['post_category_id'];
    $edit_author = $_POST['author'];
    $edit_tags = $_POST['post_tags'];
    $edit_status = $_POST['post_status'];
    $edit_img = $_FILES['post_image']['name'];
    $edit_image_temp = $_FILES['post_image']['tmp_name'];
    $edit_content = $_POST['post_content'];

    move_uploaded_file($edit_image_temp, "img/$edit_img");

    if(empty($edit_img)){
    	$query = "SELECT * FROM posts WHERE post_id=$edit_update_id";
    	$istm = $conn->query($query);
    	$istm->execute();
    	while($img = $istm->fetch(PDO::FETCH_OBJ)){
    		$edit_img = $img->post_img;
    	}
    }

    try{
        $updateQuery = "UPDATE posts SET post_title=:title, 
        post_category_id=:catid, 
        post_author=:author, 
        post_tags=:tags, 
        post_status=:status, 
        post_img=:img, 
        post_content=:content 
        WHERE post_id=:id";
        $ustm = $conn->prepare($updateQuery);
        $ustm->bindParam(":title", $edit_title);
        $ustm->bindParam(":catid", $edit_post_cat_id);
        $ustm->bindParam(":author", $edit_author);
        $ustm->bindParam(":tags", $edit_tags);
        $ustm->bindParam(":status", $edit_status);
        $ustm->bindParam(":img", $edit_img);
        $ustm->bindParam(":content", $edit_content);
        $ustm->bindParam(":id", $edit_update_id);
        $ustm->execute();
        header("Location: posts.php");
    }catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?php if(isset($show_title)){ echo $show_title; } ?>" type="text" class="form-control" name="title">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category Id</label>
		<select class="form-control" name="post_category_id" >
		<option><?php if(isset($show_post_cat_id)){ echo $show_post_cat_id; } ?></option>
		<?php 
		if(isset($_GET['source'])){

			$catQuery = "SELECT * FROM categories";
			$cstm = $conn->query($catQuery);
			$cstm->execute();

			if(!$cstm->rowCount() == 0){
				while($cat = $cstm->fetch(PDO::FETCH_OBJ)){
					$cat_id = $cat->cat_id;
					$cat_title = $cat->cat_title;
					echo "<option value='$cat_id'>$cat_title</option>";
				}
			}else{
				echo "<option>No Categories</option>";
			}
		}
		?>
		</select>
	</div>

	<div class="form-group">
		<label for="author">Post Author</label>
		<input value="<?php if(isset($show_author)){ echo $show_author; } ?>" type="text" class="form-control" name="author">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php if(isset($show_tags)){ echo $show_tags; } ?>" type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select class="form-control" name="post_status">
			<?php 
				if(isset($show_status)){ 
					echo "<option>$show_status</option>"; 
				}
				if($show_status == 'Published'){
					echo "<option>Draft</option>";
				}else{
					echo "<option>Published</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<br>
		<img style="width: 250px;" src="img/<?php if(isset($show_img)){ echo $show_img; } ?>" alt="image">
		<br>
		<br>
		<input type="file" name="post_image">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php if(isset($show_content)){ echo $show_content; } ?></textarea>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="edit_post" value="Update Post">
	</div>
</form>