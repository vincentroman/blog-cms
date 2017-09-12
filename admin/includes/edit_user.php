<?php
if(isset($_GET['u_id'])){ 
	$edit_user_id = $_GET['u_id'];
	//Show post information from databases to be edited
	try{
		$showUsersQuery = "SELECT * FROM users WHERE user_id=$edit_user_id";
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
// Submits changed value from input feild
if(isset($_POST['submit_edit_user'])){
    $edit_update_id = $_GET['u_id'];
    $edit_username = $_POST['username'];
    $edit_fname = $_POST['fname'];
    $edit_lname = $_POST['lname'];
    $edit_role = $_POST['user_role'];
    $edit_email = $_POST['user_email'];
    $edit_img = $_FILES['user_image']['name'];
    $edit_image_temp = $_FILES['user_image']['tmp_name'];

    move_uploaded_file($edit_image_temp, "def_img/$edit_img");

    if(empty($edit_img)){
    	$query = "SELECT * FROM users WHERE user_id=$edit_update_id";
    	$istm = $conn->query($query);
    	$istm->execute();
    	while($img = $istm->fetch(PDO::FETCH_OBJ)){
    		$edit_img = $img->user_image;
    	}
    }

    try{
        $updateQuery = "UPDATE users SET username=:uname, 
        user_firstname=:fname, 
        user_lastname=:lname, 
        user_role=:role,
        user_email=:email, 
        user_image=:img 
        WHERE user_id=:id";
        $ustm = $conn->prepare($updateQuery);
        $ustm->bindParam(":uname", $edit_username);
        $ustm->bindParam(":fname", $edit_fname);
        $ustm->bindParam(":lname", $edit_lname);
        $ustm->bindParam(":role", $edit_role);
        $ustm->bindParam(":email", $edit_email);
        $ustm->bindParam(":img", $edit_img);
        $ustm->bindParam(":id", $edit_update_id);
        $ustm->execute();
        header("Location: users.php");
    }catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="username">Username</label>
		<input value="<?php if(isset($show_username)){ echo $show_username; } ?>" type="text" class="form-control" name="username">
	</div>

	<div class="form-group">
		<label for="fname">First Name</label>
		<input value="<?php if(isset($show_firstname)){ echo $show_firstname; } ?>" class="form-control" type="text" name="fname">
	</div>

	<div class="form-group">
		<label for="lname">Last Name</label>
		<input value="<?php if(isset($show_lastname)){ echo $show_lastname; } ?>" type="text" class="form-control" name="lname">
	</div>

	<div class="form-group">
		<label for="user_role">User Role</label>
		<select class="form-control" name="user_role" >
			<?php 
				if(isset($show_role)){ 
					echo "<option>$show_role</option>"; 
				}
				if($show_role == 'Admin'){
					echo "<option>User</option>";
				}else{
					echo "<option>Admin</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input value="<?php if(isset($show_email)){ echo $show_email; } ?>" type="email" class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="user_image">User Image</label>
		<br>
		<img style="width: 250px;" src="def_img/<?php if(isset($show_img)){ echo $show_img; } ?>" alt="image">
		<br>
		<br>
		<input type="file" name="user_image">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="submit_edit_user" value="Update User">
	</div>
</form>