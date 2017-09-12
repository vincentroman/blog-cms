<?php 
if(isset($_POST['create_post'])){
	$post_title = $_POST['title'];
	$post_category_id = $_POST['post_category_id'];
	$post_status = $_POST['post_status'];

	$post_image = $_FILES['post_image']['name'];
	$post_image_temp = $_FILES['post_image']['tmp_name'];

	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_date = date('y-m-d');
	$post_comment_count = 4;

	if(empty($post_image)){
		$post_image_temp = 'jumbo.jpg';
	}

	move_uploaded_file($post_image_temp, "img/$post_image");

	

	try{
		$newPostQuery = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_img, post_content, post_tags, post_comment_count, post_status) 
		VALUES (:catid, :title, :author, :postdate, :image, :content, :tags, :commentcount, :status)";
		$npstm = $conn->prepare($newPostQuery);

		$npstm->bindParam(":catid", $post_category_id);
		$npstm->bindParam(":title", $post_title);
		$npstm->bindParam(":author", $username);
		$npstm->bindParam(":postdate", $post_date);
		$npstm->bindParam(":image", $post_image);
		$npstm->bindParam(":content", $post_content);
		$npstm->bindParam(":tags", $post_tags);
		$npstm->bindParam(":commentcount", $post_comment_count);
		$npstm->bindParam(":status", $post_status);

		$npstm->execute();
		header("Location: posts.php");
	}catch(PDOException $ex){
		echo "Error: " . $ex->getMessage();
	}
}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category Id</label>
		<select class="form-control" name="post_category_id" >
			<option>Category</option>
		<?php 
		if(isset($_GET['source'])){
			$catQuery = "SELECT * FROM categories";
			$cstm = $conn->query($catQuery);
			$cstm->execute();

			if(!$cstm->rowCount() == 0){
				while($cat = $cstm->fetch(PDO::FETCH_OBJ)){
					$cat_val = $cat->cat_id;
					$cat_op = $cat->cat_title;
					echo "<option value='$cat_val'>$cat_op</option>";
				}
			}else{
				echo "<option>No Categories</option>";
			}
		}
		?>
		</select>
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select class="form-control" name="post_status">
			<option>Draft</option>
			<option>Published</option>
		</select>
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="post_image">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
	</div>
</form>