<?php 
ob_start();
require 'bootstrap.php';
include 'includes/header.php';
include 'controllers/register.php';
?>
<div class="container">
	<div class="well">
	<h2 class="text-center">Register</h2>
		<div class="row">
			<div class="col-xs-12">
				<form id="register_form" method="post" action="">
					<div class="form-group">
						<label for="first_name">First Name</label>
						 <input class="form-control" type="text" name="first_name">
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input class="form-control" type="text" name="last_name">
					</div>
					<div class="form-group">
						<label for="user_name">Username</label>
						<input class="form-control" type="text" name="user_name">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input class="form-control" type="text" name="email" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="password" name="password" autocomplete="off">
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm Password</label>
						<input class="form-control" type="password" name="confirm_password" autocomplete="off">
					</div>
					<input class="btn btn-primary" type="submit" value="Register" name="register_user">
				</form><!--End of #register_form-->
			</div>
		</div>
	</div>
<?php include 'includes/footer.php'; ?>