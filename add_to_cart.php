<?php
session_start();
include("db.php");

// Check product ID
if(!isset($_GET['id'])){
    header("Location: home.php");
    exit();
}

$product_id = intval($_GET['id']);

// If user not logged in
if(!isset($_SESSION['user_id'])){

    // Save product for later
    $_SESSION['redirect_product_id'] = $product_id;

    // Go login first
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check existing item
$check = $conn->query("
    SELECT * FROM cart 
    WHERE user_id='$user_id' 
    AND product_id='$product_id'
");

if($check->num_rows > 0){

    // Increase quantity
    $conn->query("
        UPDATE cart 
        SET quantity = quantity + 1
        WHERE user_id='$user_id'
        AND product_id='$product_id'
    ");

}else{

    // Add new product
    $conn->query("
        INSERT INTO cart(user_id, product_id, quantity)
        VALUES('$user_id','$product_id',1)
    ");
}

header("Location: home.php");
exit();
?>