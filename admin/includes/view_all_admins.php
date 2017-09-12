<?php ob_start(); ?>
        <?php 
            $userQuery = "SELECT * FROM users WHERE user_role='Admin'";
            $urstm = $conn->query($userQuery);
            $urstm->execute();

            if(!$urstm->rowCount() == 0){
                echo "<table class='table table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Username</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($user = $urstm->fetch(PDO::FETCH_OBJ)){
                    $user_id = $user->user_id;
                    echo "<tr>";
                    echo "<td>$user_id</td>";
                    echo "<td>$user->username</td>";
                    echo "<td><img style='width:50px;' src='def_img/$user->user_image'></td>";
                    echo "<td>$user->user_firstname</td>";
                    echo "<td>$user->user_lastname</td>";
                    echo "<td>$user->user_email</td>";
                    echo "<td>$user->user_role</td>";
                    echo "<td>$user->user_status</td>";
                    echo "<td><button class='btn btn-info'><a style='color:#fff;' href='users.php?source=edit_user&u_id=$user_id'>Edit</a></button></td>";
                    echo "<td><button class='btn btn-danger'><a style='color:#fff;' href='users.php?delete=$user_id'>Delete</a></button></td>";
                    echo "<td><button class='btn btn-success'><a style='color:#fff;' href='users.php?approve=$user_id'>Approve</a></button></td>";
                    echo "<td><button class='btn btn-warning'><a style='color:#fff;' href='users.php?unapprove=$user_id'>Unapprove</a></button></td>";
                    echo "</tr>";
                }
                echo "</tbody>
                </table>";
            } else {
                echo "<h2 class='alert alert-info'><strong>Sorry!</strong> There are no current users. <a href='users.php?source=add_user'>Add A User</a></h2>";
            }

//Delete Comment Query
if(isset($_GET['delete'])){
    $userId = $_GET['delete'];
    $deleteUserQuery = "DELETE FROM users WHERE user_id=:id";
    $dustm = $conn->prepare($deleteUserQuery);
    $dustm->bindParam(":id", $userId);
    $dustm->execute();
    header("Location: users.php?source=list_admins");
}

//Approve User Query
if(isset($_GET['approve'])){
    $userId = $_GET['approve'];
    $approveUserQuery = "UPDATE users SET user_status='Approved' WHERE user_id=:id";
    $austm = $conn->prepare($approveUserQuery);
    $austm->bindParam(":id", $userId);
    $austm->execute();
    header("Location: users.php?source=list_admins");
}

// Unapprove User Query
if(isset($_GET['unapprove'])){
    $userId = $_GET['unapprove'];
    $unapproveUserQuery = "UPDATE users SET user_status='Unapproved' WHERE user_id=:id";
    $uaustm = $conn->prepare($unapproveUserQuery);
    $uaustm->bindParam(":id", $userId);
    $uaustm->execute();
    header("Location: users.php?source=list_admins");
}
?>