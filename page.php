<?php include("db.php"); ?>

<h2>Products</h2>

<div class="products">
<?php
$result = $conn->query("SELECT * FROM products");

while($row = $result->fetch_assoc()){
?>
    <div class="card">
        <img src="images/<?php echo $row['image']; ?>">
        <h3><?php echo $row['name']; ?></h3>
        <p>$<?php echo $row['price']; ?></p>

        <form action="add_to_cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <button>Add to Cart</button>
        </form>
    </div>
<?php } ?>
</div>