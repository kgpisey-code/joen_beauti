<?php
session_start();
include("../db.php");

// protect page
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
?>

<h2>Your Cart</h2>

<?php
$result = $conn->query("
    SELECT cart.id, products.name, products.price, cart.quantity
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
");

$total = 0;

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
?>

<div style="background:white; padding:10px; margin:10px; border-radius:10px;">
    <b><?php echo $row['name']; ?></b><br>
    Price: $<?php echo $row['price']; ?><br>
    Quantity: <?php echo $row['quantity']; ?><br>

    <!-- update -->
    <form action="update_cart.php" method="POST" style="display:inline;">
        <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
        <input type="number" name="qty" value="<?php echo $row['quantity']; ?>" min="1">
        <button>Update</button>
    </form>

    <!-- remove -->
    <form action="remove_cart.php" method="POST" style="display:inline;">
        <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
        <button>Remove</button>
    </form>
</div>

<?php 
    }
} else {
    echo "<p>Your cart is empty 🛒</p>";
}
?>

<h3>Total: $<?php echo $total; ?></h3>

<a href="checkout.php">
    <button>Checkout</button>
</a>