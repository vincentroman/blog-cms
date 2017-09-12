<?php 
if(isset($_POST['create_user'])){
	$user_username = $_POST['username'];
	$user_firstname = $_POST['fname'];
	$user_lastname = $_POST['lname'];
	$user_role = $_POST['user_role'];
	$user_email = $_POST['user_email'];
	$user_image = $_FILES['user_image']['name'];
	$user_image_temp = $_FILES['user_image']['tmp_name'];
	$user_password = $_POST['user_password'];
	$user_date = date('y-m-d');

	move_uploaded_file($user_image_temp, "def_img/$user_image");

	if(empty($user_username)){
		$user_username = strtolower(substr($user_firstname, 0, 1)) . strtolower($user_lastname) . round(rand(0,300));
	}
	if(empty($user_image)){
		$user_image = 'card.jpg';
	}
	if(empty($user_role)){
		$user_role = 'Subscriber';
	}

	try{
		$newUserQuery = "INSERT INTO users(username, user_firstname, user_lastname, start_date, user_image, user_email, user_password, user_role) 
		VALUES (:uname, :fname, :lname, :startdate, :image, :email, :pword, :role)";
		$nurstm = $conn->prepare($newUserQuery);

		$nurstm->bindParam(":uname", $user_username);
		$nurstm->bindParam(":fname", $user_firstname);
		$nurstm->bindParam(":lname", $user_lastname);
		$nurstm->bindParam(":startdate", $user_date);
		$nurstm->bindParam(":image", $user_image);
		$nurstm->bindParam(":email", $user_email);
		$nurstm->bindParam(":pword", password_hash($user_password, PASSWORD_BCRYPT));
		$nurstm->bindParam(":role", $user_role);

		$nurstm->execute();
		header("Location: users.php");
	}catch(PDOException $ex){
		echo "Error: " . $ex->getMessage();
	}
}
?>

<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username">
	</div>

	<div class="form-group">
		<label for="fname">First Name</label>
		<input type="text" class="form-control" name="fname">
	</div>

	<div class="form-group">
		<label for="lname">Last Name</label>
		<input type="text" class="form-control" name="lname">
	</div>

	<div class="form-group">
		<label for="user_role">Role</label>
		<select class="form-control" name="user_role">
			<option>User</option>
			<option>Admin</option>
		</select>
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="text" class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="user_password">Password</label>
		<input type="password" class="form-control" name="user_password">
	</div>

	<div class="form-group">
		<label for="user_image">User Image</label>
		<input type="file" class="form-control" name="user_image">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_user" value="Create User">
	</div>
</form>