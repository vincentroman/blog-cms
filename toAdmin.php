<?php
ob_start();
require "includes/db.php";
try
{
    $usersCount = "SELECT COUNT(*) AS 'num' FROM users";
    $results = $conn->query($usersCount);
    $results->execute();

    while($users = $results->fetch(PDO::FETCH_OBJ)){
        $number = $users->num;
        if($number == 1){
            try
            {
                $query = "UPDATE users SET user_role='Admin' WHERE user_id=1";
                $action = $conn->query($query);
                $action->execute();
                echo "You are now the admin user.";
                echo "<br>";
                echo "<button style='background: #ccc;'><a href='/login.php'>Go to Login</a></button>";
            }
            catch(PDOException $ex)
            {
                echo "Error: " . $ex->getMessage();
            }     
        } else {
            header('Location: /login.php');
        }
    }
}
catch(PDOException $ex)
{
    echo "Error: " . $ex->getMessage();
}

