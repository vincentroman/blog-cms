<?php ob_start(); 

$userQuery = "SELECT * FROM subscribers";
$urstm = $conn->query($userQuery);
$urstm->execute();

if(!$urstm->rowCount() == 0){
    echo "<table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>";
    while($user = $urstm->fetch(PDO::FETCH_OBJ)){
        $sub_id = $user->sub_id;
        echo "<tr>";
        echo "<td>$sub_id</td>";
        echo "<td>$user->sub_username</td>";
        echo "<td>$user->sub_email</td>";
        echo "<td><button class='btn btn-danger'><a style='color:#fff;' href='users.php?source=list_subs&delete=$sub_id'>Delete</a></button></td>";
        echo "</tr>";
    }
    echo "</tbody>
        </table>";
} else {
    echo "<h2 class='alert alert-info'><strong>Sorry!</strong> There are no current subscribers.</h2>";
}

//Delete Comment Query
if(isset($_GET['delete'])){
    $userId = $_GET['delete'];
    $deleteUserQuery = "DELETE FROM subscribers WHERE sub_id=:id";
    $dustm = $conn->prepare($deleteUserQuery);
    $dustm->bindParam(":id", $userId);
    $dustm->execute();
    header("Location: users.php?source=list_subs");
}
?>








