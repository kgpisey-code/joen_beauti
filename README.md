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
<?php
session_start();
include("db.php");

$count = 0;
$username = "";

// Check login
if(isset($_SESSION['user_id'])){

    $uid = $_SESSION['user_id'];

    // Cart count
    $cartQuery = "SELECT SUM(quantity) AS total 
                  FROM cart 
                  WHERE user_id='$uid'";

    $cartResult = $conn->query($cartQuery);

    if($cartResult){
        $cartData = $cartResult->fetch_assoc();
        $count = $cartData['total'] ?? 0;
    }

    // Username
    $userQuery = "SELECT user_name 
                  FROM users 
                  WHERE id='$uid'";

    $userResult = $conn->query($userQuery);

    if($userResult){
        $userData = $userResult->fetch_assoc();
        $username = $userData['user_name'] ?? "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>About Us | JOEN BEAUTI</title>

<link rel="icon" type="image/png" href="joen_logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f6f6f6;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* NAVBAR */

.custom-nav{
    display:flex;
    align-items:center;
    justify-content:space-between;
    height:70px;
    margin:15px;
    padding:0 30px;
    background:white;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);

    position:sticky;
    top:15px;
    z-index:1000;
}

.nav-logo-sm{
    width:60px;
}

.nav-center{
    display:flex;
    gap:30px;
}

.nav-link{
    text-decoration:none;
    color:#111;
    font-weight:500;
}

.nav-link:hover{
    color:#ba4aa1;
}

.nav-menu{
    display:flex;
    align-items:center;
    gap:15px;
}

.icon{
    height:22px;
}

.cart-box{
    position:relative;
}

.cart-count{
    position:absolute;
    top:-6px;
    right:-8px;
    background:#ba4aa1;
    color:white;
    font-size:11px;
    padding:2px 6px;
    border-radius:50%;
}

.user-welcome{
    font-size:14px;
    color:#555;
}

/* HERO */

.about-hero{
    background:white;
    border-radius:25px;
    padding:70px 40px;
    margin-top:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

.about-title{
    font-size:48px;
    font-weight:700;
}

.about-text{
    color:#666;
    line-height:1.9;
}

/* FEATURES */

.feature-card{
    background:white;
    border-radius:20px;
    padding:30px;
    text-align:center;
    height:100%;
    box-shadow:0 5px 18px rgba(0,0,0,0.05);
    transition:0.3s;
}

.feature-card:hover{
    transform:translateY(-5px);
}

.feature-icon{
    font-size:40px;
    margin-bottom:15px;
}

/* FOOTER */

.footer-section{
    background:white;
    margin-top:80px;
}

.footer-links a{
    text-decoration:none;
    color:#666;
    line-height:2;
}

.footer-links a:hover{
    color:#ba4aa1;
}

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="custom-nav">

    <div>
        <a href="home.php">
            <img src="joen_logo.png" class="nav-logo-sm">
        </a>
    </div>

    <div class="nav-center">
        <a href="home.php" class="nav-link">Shop</a>
        <a href="about.php" class="nav-link">About</a>
        <a href="contact.php" class="nav-link">Contact</a>
    </div>

    <div class="nav-menu">

        <?php if($username): ?>

            <span class="user-welcome">
                Hi, <?php echo htmlspecialchars($username); ?>
            </span>

            <a href="logout.php" class="nav-link">
                Logout
            </a>

        <?php else: ?>

          

        <?php endif; ?>

        <a href="card.php" class="cart-box">
            <img src="bag.png" class="icon">

            <?php if($count > 0): ?>
                <span class="cart-count">
                    <?php echo $count; ?>
                </span>
            <?php endif; ?>
        </a>

    </div>

</nav>

<!-- ABOUT HERO -->

<div class="container">

    <div class="about-hero">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1 class="about-title mb-4">
                    About JOEN BEAUTI
                </h1>

                <p class="about-text">
                    JOEN BEAUTI is a modern skincare and beauty shop dedicated to helping people feel confident and beautiful every day.
                </p>

                <p class="about-text">
                    We carefully select premium skincare products from trusted brands around the world. Our mission is to provide high-quality beauty essentials with elegant design, smooth shopping experience, and excellent customer care.
                </p>

            </div>

            <div class="col-lg-6 text-center">

                <img src="joen_logo.png"
                     class="img-fluid rounded-4 shadow"
                     style="max-height:450px; object-fit:cover;">

            </div>

        </div>

    </div>

</div>

<!-- FEATURES -->
<div class="container mt-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold" style="font-size:40px;">
            Why Choose JOEN BEAUTI
        </h2>

        <p class="text-muted">
            Experience premium skincare with elegance, quality, and care.
        </p>
    </div>

    <div class="row g-4">

        <!-- CARD 1 -->

        <div class="col-md-4">

            <div class="feature-card p-4 bg-white rounded-4 shadow-sm h-100 text-center">

                <div class="feature-icon mb-4">

                    <div style="
                        width:90px;
                        height:90px;
                        background:#fff0fa;
                        border-radius:50%;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        margin:auto;
                    ">

                        <img src="product.png"
                             style="width:45px; height:45px; object-fit:contain;">

                    </div>

                </div>

                <h4 class="fw-bold mb-3">
                    Premium Products
                </h4>

                <p class="text-muted" style="line-height:1.8;">
                    Carefully selected skincare and beauty essentials from trusted international brands designed to nourish and protect your skin.
                </p>

            </div>

        </div>

        <!-- CARD 2 -->

        <div class="col-md-4">

            <div class="feature-card p-4 bg-white rounded-4 shadow-sm h-100 text-center">

                <div class="feature-icon mb-4">

                    <div style="
                        width:90px;
                        height:90px;
                        background:#eef9ff;
                        border-radius:50%;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        margin:auto;
                    ">

                        <img src="delivery.png"
                             style="width:45px; height:45px; object-fit:contain;">

                    </div>

                </div>

                <h4 class="fw-bold mb-3">
                    Fast Delivery
                </h4>

                <p class="text-muted" style="line-height:1.8;">
                    Enjoy reliable and secure delivery services that bring your favorite beauty products directly to your doorstep quickly.
                </p>

            </div>

        </div>

        <!-- CARD 3 -->

        <div class="col-md-4">

            <div class="feature-card p-4 bg-white rounded-4 shadow-sm h-100 text-center">

                <div class="feature-icon mb-4">

                    <div style="
                        width:90px;
                        height:90px;
                        background:#fff5ec;
                        border-radius:50%;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        margin:auto;
                    ">

                        <img src="customer.png"
                             style="width:45px; height:45px; object-fit:contain;">

                    </div>

                </div>

                <h4 class="fw-bold mb-3">
                    Customer Care
                </h4>

                <p class="text-muted" style="line-height:1.8;">
                    Our friendly support team is always ready to help you with product recommendations and shopping assistance.
                </p>

            </div>

        </div>

    </div>

</div>
<!-- FOOTER -->

<footer class="footer-section mt-5">

    <div class="container py-5">

        <div class="row">

            <div class="col-lg-6">

                <h5 class="fw-bold mb-3">
                    JOEN BEAUTI
                </h5>

                <p class="text-muted">
                    Elegant skincare and beauty shopping experience designed with care and passion.
                </p>

            </div>

            <div class="col-lg-6 text-lg-end">

                <p class="text-muted mb-0">
                    © 2026 JOEN BEAUTI. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</footer>

</body>
</html>
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
/* =======================
            PRODUCT CARDS
        ======================= */
        .product-grid {
            padding: 40px 30px;
        }

        .product-card {
            background: #fff;
            border: none;
            border-radius: 20px; /* Highly rounded corners */
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            height: 100%;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1a1a1a;
        }

        .product-price {
            float: right;
            font-weight: 600;
            color: #1a1a1a;
        }

        .product-desc {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 20px;
            display: block;
        }

        .btn-add-cart {
            width: 100%;
            background: #f8f8f8;
            color: #1a1a1a;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-add-cart:hover {
            background: #000;
            color: #fff;
        }

        /* Specific style for the dark button shown in your image */
        .btn-dark-custom {
            background: #1a1a1a;
            color: #fff;
        }
<?php
session_start();
include("db.php");

$count = 0;
$username = "";

// Check login
if(isset($_SESSION['user_id'])){

    $uid = $_SESSION['user_id'];

    // Cart count
    $cartQuery = "SELECT SUM(quantity) AS total 
                  FROM cart 
                  WHERE user_id='$uid'";

    $cartResult = $conn->query($cartQuery);

    if($cartResult){
        $cartData = $cartResult->fetch_assoc();
        $count = $cartData['total'] ?? 0;
    }

    // Username
    $userQuery = "SELECT user_name 
                  FROM users 
                  WHERE id='$uid'";

    $userResult = $conn->query($userQuery);

    if($userResult){
        $userData = $userResult->fetch_assoc();
        $username = $userData['user_name'] ?? "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact | JOEN BEAUTI</title>

<link rel="icon" type="image/png" href="joen_logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f6f6f6;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* NAVBAR */

.custom-nav{
    display:flex;
    align-items:center;
    justify-content:space-between;
    height:70px;
    margin:15px;
    padding:0 30px;
    background:white;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);

    position:sticky;
    top:15px;
    z-index:1000;
}

.nav-logo-sm{
    width:60px;
}

.nav-center{
    display:flex;
    gap:30px;
}

.nav-link{
    text-decoration:none;
    color:#111;
    font-weight:500;
}

.nav-link:hover{
    color:#ba4aa1;
}

.nav-menu{
    display:flex;
    align-items:center;
    gap:15px;
}

.icon{
    height:22px;
}

.cart-box{
    position:relative;
}

.cart-count{
    position:absolute;
    top:-6px;
    right:-8px;
    background:#ba4aa1;
    color:white;
    font-size:11px;
    padding:2px 6px;
    border-radius:50%;
}

.user-welcome{
    font-size:14px;
    color:#555;
}

/* CONTACT */

.contact-section{
    margin-top:40px;
}

.contact-card{
    background:white;
    border-radius:25px;
    padding:50px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

.contact-title{
    font-size:42px;
    font-weight:700;
}

.contact-info{
    background:#fafafa;
    border-radius:20px;
    padding:30px;
    height:100%;
}

.info-item{
    margin-bottom:25px;
}

.info-title{
    font-weight:600;
    margin-bottom:5px;
}

.form-control{
    border:none;
    background:#f3f3f3;
    padding:14px;
    border-radius:12px;
}

.form-control:focus{
    box-shadow:none;
    border:1px solid #ba4aa1;
    background:white;
}

.send-btn{
    background:#111;
    color:white;
    border:none;
    padding:14px;
    border-radius:12px;
    transition:0.3s;
}

.send-btn:hover{
    background:#ba4aa1;
}

/* FOOTER */

.footer-section{
    background:white;
    margin-top:80px;
}

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="custom-nav">

    <div>
        <a href="home.php">
            <img src="joen_logo.png" class="nav-logo-sm">
        </a>
    </div>

    <div class="nav-center">
        <a href="index.php" class="nav-link">Shop</a>
        <a href="about.php" class="nav-link">About</a>
        <a href="contact.php" class="nav-link">Contact</a>
    </div>

    <div class="nav-menu">

        <?php if($username): ?>

            <span class="user-welcome">
                Hi, <?php echo htmlspecialchars($username); ?>
            </span>

            <a href="logout.php" class="nav-link">
                Logout
            </a>

        <?php else: ?>

            

        <?php endif; ?>

        <a href="card.php" class="cart-box">

            <img src="bag.png" class="icon">

            <?php if($count > 0): ?>

                <span class="cart-count">
                    <?php echo $count; ?>
                </span>

            <?php endif; ?>

        </a>

    </div>

</nav>

<!-- CONTACT SECTION -->

<div class="container contact-section">

    <div class="contact-card">

        <div class="row g-5 align-items-center">

            <!-- LEFT -->

            <div class="col-lg-5">

                <h1 class="contact-title mb-4">
                    Contact Us
                </h1>

                <p class="text-muted mb-5" style="line-height:1.9;">
                    We'd love to hear from you. Whether you have a question about products, delivery, or skincare recommendations, our team is ready to help.
                </p>

                <div class="contact-info">

                    <div class="info-item">

                        <div class="info-title">
                            <img src="address.png"
                             style="width:20px; height:20px; object-fit:contain;"> 
                             Address
                        </div>

                        <div class="text-muted">
                            Phnom Penh, Cambodia
                        </div>

                    </div>

                    <div class="info-item">

                        <div class="info-title">
                            <img src="phone.png"
                             style="width:20px; height:20px; object-fit:contain;">  Phone
                        </div>

                        <div class="text-muted">
                            +855 86 94 66 76
                        </div>

                    </div>

                    <div class="info-item">

                        <div class="info-title">
                            <img src="email.png"
                             style="width:20px; height:20px; object-fit:contain;">  Email
                        </div>

                        <div class="text-muted">
                            support@joenbeauti.com
                        </div>

                    </div>

                    <div class="info-item mb-0">

                        <div class="info-title">
                            <img src="time.png"
                             style="width:20px; height:20px; object-fit:contain;">  Working Hours
                        </div>

                        <div class="text-muted">
                            Monday - Sunday : 8AM - 9PM
                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-7">

                <form>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <input type="text"
                                   class="form-control"
                                   placeholder="Your Name">

                        </div>

                        <div class="col-md-6">

                            <input type="email"
                                   class="form-control"
                                   placeholder="Email Address">

                        </div>

                        <div class="col-12">

                            <input type="text"
                                   class="form-control"
                                   placeholder="Subject">

                        </div>

                        <div class="col-12">

                            <textarea class="form-control"
                                      rows="6"
                                      placeholder="Write your message..."></textarea>

                        </div>

                        <div class="col-12">

                            <button class="send-btn w-100">
                                Send Message
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- FOOTER -->

<footer class="footer-section mt-5">

    <div class="container py-5">

        <div class="row">

            <div class="col-lg-6">

                <h5 class="fw-bold mb-3">
                    JOEN BEAUTI
                </h5>

                <p class="text-muted">
                    Elegant skincare and beauty shopping experience designed with care and passion.
                </p>

            </div>

            <div class="col-lg-6 text-lg-end">

                <p class="text-muted mb-0">
                    © 2026 JOEN BEAUTI. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</footer>

</body>
</html>
<?php
$conn = new mysqli("localhost", "root", "", "joen_beauti");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<?php
session_start();
include("db.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password = $_POST['password'];

   $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        // Check password
        if($password == $user['password']){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['user_name'];

            // Return to cart
            if(isset($_SESSION['redirect_product_id'])){

                $pid = $_SESSION['redirect_product_id'];

                unset($_SESSION['redirect_product_id']);

                header("Location: add_to_cart.php?id=$pid");
                exit();
            }

            header("Location: home.php");
            exit();

        }else{
            $error = "Wrong password";
        }

    }else{
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-box{
    width:400px;
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

</style>

</head>
<body>

<div class="login-box">

    <h3 class="text-center mb-4">Login</h3>

    <?php if($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-dark w-100">
            Login
        </button>

    </form>

</div>

</body>
</html>
