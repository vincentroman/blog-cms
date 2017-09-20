<?php

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