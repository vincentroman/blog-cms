<?php

/*_______________________________________Login Script_______________________________________*/
if(isset($_POST['login_user'])){
    $email = $_POST['email'];
    $pword = $_POST['password'];

    $validateQuery = 'SELECT user_id,user_email,username,user_firstname,user_lastname,user_image,user_role,user_password FROM users WHERE user_email=:email';
    $records = $conn->prepare($validateQuery);
    $records->bindParam(':email', $email);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(!$email) {
        $message = "An email address is required. <br>";
    } else if (!$pword) {
        $message = "A password is required. <br>";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $message = "Please enter a valid email address. <br>";
    } else if (count($results) == 0 || password_verify($pword, $results['user_password']) == false) {
        $message = "<strong>Sorry!</strong> Email and Password do not match. Please try again. <br>";
    } else {
        $message = "";
    }

    if(count($results) > 0 && password_verify($pword, $results['user_password'])){

        $_SESSION['user_id'] = $results['user_id'];
        $_SESSION['user_email'] = $results['user_email'];
        $_SESSION['username'] = $results['username'];
        $_SESSION['firstname'] = $results['user_firstname'];
        $_SESSION['lastname'] = $results['user_lastname'];
        $_SESSION['role'] = $results['user_role'];
        $_SESSION['image'] = $results['user_image'];
        if($_SESSION['role'] === 'Admin'){
            header('Location: admin/index.php');
        } else {
            header('Location: admin/profile.php');
        }
    }
}
/*_______________________________________End of Login Script_______________________________________*/