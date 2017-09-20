<?php 
ob_start();
session_start();
require 'bootstrap.php';
include 'includes/header.php';
include 'controllers/login.php';
?>
<div class="container">
	<div class="well">
	<h2 class="text-center">Login</h2>
		<div class="row">
			<div class="col-xs-12">
				<form id="login_form" method="post" action="">
					<div class="form-group">
						<label for="email">Email</label>
						<input class="form-control" type="text" name="email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="password" name="password">
					</div>
					<input class="btn btn-primary" type="submit" value="Login" name="login_user">
				</form><!-- End of #login_form -->
			</div>
		</div>
	</div>
<?php include 'includes/footer.php'; ?>