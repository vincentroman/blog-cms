<?php
require '../bootstrap.php';

/*_______________________________________Register Script_______________________________________*/
if(isset($_POST['register_user'])){

    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $uname = $_POST['user_name'];
    $email = $_POST['email'];
    $pword = $_POST['password'];
    $image = 'card.jpg';
    $role = 'User';
    $start_date = date('y-m-d');
    $status = 'Approved';
    $con_pword = $_POST['confirm_password'];

    if(empty($uname)){
        $uname = strtolower(substr($fname, 0, 1)) . strtolower($lname) . round(rand(0,300));
    }

    try{
        $regUser = "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_password, user_image, user_role, start_date, user_status) 
        VALUES(:fname, :lname, :uname, :email, :password, :img, :role, :start_date, :status)";
        $rustm = $conn->prepare($regUser);
        $rustm->bindParam(':fname', $fname);
        $rustm->bindParam(':lname', $lname);
        $rustm->bindParam(':uname', $uname);
        $rustm->bindParam(':email', $email);
        $rustm->bindParam(':password', password_hash($pword, PASSWORD_BCRYPT));
        $rustm->bindParam(':img', $image);
        $rustm->bindParam(':role', $role);
        $rustm->bindParam(':start_date', $start_date);
        $rustm->bindParam(':status', $status);
        $rustm->execute();
        header("Location: admin/users.php");
    }catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }       
}
/*_______________________________________End of Register Script_______________________________________*/


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