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