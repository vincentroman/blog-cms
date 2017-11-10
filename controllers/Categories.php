<?php 
require '../bootstrap.php';

// Get all categories
//http://localhost.dev?categories
if(isset($_GET['categories'])){
    try{
        $query = "SELECT * FROM categories";
        $stm = $conn->query($query);
        $stm->execute();
        echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));
    } catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}

// Get Category by ID 
//http://localhost.dev?edit=1
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    try{
        $query = "SELECT * FROM categories WHERE cat_id=:id";
        $stm = $conn->prepare($query);
        $stm->bindParam(":id", $id);
        $stm->execute();
        echo json_encode($stm->fetch(PDO::FETCH_ASSOC));
    } catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}


// Add Category Query
//http://localhost.dev?category=dogs
if(isset($_POST['category'])){
    $value = $_POST['category'];
    try{
        $query = "INSERT INTO categories(cat_title) VALUES (:title)";
        $stm = $conn->prepare($query);
        $stm->bindParam(":title", $value);
        $stm->execute();
        echo json_encode($stm->fetch(PDO::FETCH_ASSOC));
    } catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}


// Update Category
//http://localhost.dev?update=category%id=1
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $value = $_POST['update'];
    try{
        $query = "UPDATE categories SET cat_title=:title WHERE cat_id=:id";
        $stm = $conn->prepare($query);
        $stm->bindParam(":title", $value);
        $stm->bindParam(":id", $id);
        $stm->execute();
        echo $id;
    }catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
}

// Delete Category
//http://localhost.dev?delete_id=1
 if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    try{
        $query = "DELETE FROM categories WHERE cat_id = :id";
        $stm = $conn->prepare($query);
        $stm->bindParam(":id", $id);
        $stm->execute();
        echo $id;
    }catch(PDOException $ex){
        echo "Error: " . $ex->getMessage();
    }
 }