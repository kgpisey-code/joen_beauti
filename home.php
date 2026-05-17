<?php
session_start();
include("db.php"); // Ensure this file points to 'joen_beauti'

$count = 0;
$username = "";

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    // Get total cart items
    $cartQuery = "SELECT SUM(quantity) AS total FROM cart WHERE user_id='$uid'";
    $cartResult = $conn->query($cartQuery);
    if ($cartResult) {
        $cartData = $cartResult->fetch_assoc();
        $count = $cartData['total'] ?? 0;
    }

    // Get username
    $userQuery = "SELECT username FROM users WHERE id='$uid'";
    $userResult = $conn->query($userQuery);
    if ($userResult) {
        $userData = $userResult->fetch_assoc();
        $username = $userData['username'] ?? "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOEN_SHOP</title>

    <link rel="icon" type="image/png" href="joen_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="card.css">

    <style>
        body { background: #f6f6f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
       .custom-nav {
    /* Layout & Spacing */
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    margin: 15px;
    padding: 0 30px;

    /* Styling */
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);

    /* Sticky Behavior */
    position: sticky;
    top: 15px;      /* Keeps the 15px gap at the top when scrolling */
    z-index: 1050;  /* High index to stay above product cards and shadows */

        }
        .nav-logo-sm { width: 60px; object-fit: contain; }
        .nav-center { display: flex; gap: 30px; }
        .nav-link { text-decoration: none; color: #0c0c0c; font-weight: 500; transition: 0.3s; }
        .nav-link:hover { color: #ba4aa1; }
        .nav-menu { display: flex; align-items: center; gap: 12px; }
        .nav-menu a { padding: 6px; border-radius: 8px; transition: 0.25s; }
        .nav-menu a:hover { background: #f0f0f0; }
        .icon { height: 22px; }
        .cart-box { position: relative; }
        .cart-count {
            position: absolute; top: -6px; right: -8px;
            background: #ba4aa1; color: white; font-size: 11px;
            padding: 2px 6px; border-radius: 50%; font-weight: bold;
        }
        .user-welcome { font-size: 14px; color: #555; margin-right: 10px; }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="custom-nav">
    <div class="nav-left">
        <a href="home.php">
            <img src="joen_logo.png" class="nav-logo-sm" alt="Logo">
        </a>
    </div>

    <div class="nav-center">
        <a href="home.php" class="nav-link">Shop</a>
        <a href="about.php" class="nav-link">About</a>
        <a href="contact.php" class="nav-link">Contact</a>
    </div>

    <div class="nav-menu">
        <?php if(isset($_SESSION['user_id'])): ?>

    <span class="user-welcome">
        Hi, <?php echo htmlspecialchars($username); ?>
    </span>

    <a href="logout.php" class="nav-link">
        Logout
    </a>

<?php else: ?>

   

<?php endif; ?>
        <?php if($username): ?>
            <span class="user-welcome">Hi, <?php echo htmlspecialchars($username); ?></span>
        <?php endif; ?>
        
       

        <a href="card.php" class="cart-box">
            <img src="bag.png" class="icon" alt="Cart">
            <?php if($count > 0): ?>
                <span class="cart-count"><?php echo $count; ?></span>
            <?php endif; ?>
        </a>
    </div>
</nav>

<!-- PRODUCT GRID -->
<div class="container mt-4">
    <div class="row g-4">
        <?php
        // Fetch products from 'joen_beauti' database
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Ensure variables match your database column names
                $p_id    = $row['id'];
                $p_name  = $row['name'];
                $p_price = $row['price'];
                $p_desc  = $row['description'];
                $p_img   = $row['image'];
                ?>
                <div class="col-md-4 col-lg-3">
                    <div class="product-card shadow-sm border-0 h-100 bg-white p-3 rounded-4">
                        <img src="uploads/<?php echo $p_img; ?>" class="product-image w-100 rounded-3 mb-3" alt="<?php echo $p_name; ?>">
                        
                        <div class="product-info">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="product-title m-0 fw-bold"><?php echo $p_name; ?></h6>
                                <span class="product-price text-primary fw-bold">$<?php echo number_format($p_price, 2); ?></span>
                            </div>

                            <p class="product-desc text-muted small mb-3"><?php echo $p_desc; ?></p>

                            <a href="add_to_cart.php?id=<?php echo $p_id; ?>" class="btn btn-outline-dark w-100 rounded-pill d-flex align-items-center justify-content-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                  <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 2H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
                
                <?php
            }
        } else {
            echo "<div class='col-12 text-center my-5'><p class='text-muted'>No products available right now.</p></div>";
        }
        ?>
    </div>
</div>
<!-- FOOTER -->
<footer class="footer-section mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Branding/About -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">JOEN BEAUTI</h5>
                <p class="text-muted small">Curated premium skincare and beauty essentials from global brands. Quality care for your skin, delivered with passion.</p>
                <div class="social-links mt-3">
                    <a href="https://www.facebook.com/pisey.koeung" class="me-3"><img src="facebook1.png" style="height: 20px;" alt="FB"></a>
                    <a href="https://web.telegram.org/k/"><img src="telegram.png" style="height: 20px;" alt="TG"></a>
                </div>
            </div>

            <!-- Shop Links -->
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3">Shop</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="home.php">All products</a></li>
                    <li><a href="category.php?type=cleanser">Cleansers</a></li>
                    <li><a href="category.php?type=serum">Serums</a></li>
                    <li><a href="category.php?type=sunscreen">Sunscreen</a></li>
                </ul>
            </div>

            <!-- Company Links -->
            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3">Company</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="about.php">About us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="#">Shipping policy</a></li>
                    <li><a href="#">Returns policy</a></li>
                </ul>
            </div>

            <!-- Newsletter or Contact info -->
            <div class="col-lg-4">
                <h6 class="fw-bold mb-3">Connect</h6>
                <p class="text-muted small">Join our community for skin tips and new arrivals.</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm border-0" placeholder="Email address">
                    <button class="btn btn-dark btn-sm px-3" type="button">Join</button>
                </div>
            </div>
        </div>

        <hr class="my-4 text-muted">

        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted small mb-0">© 2026 JOEN BEAUTI. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>