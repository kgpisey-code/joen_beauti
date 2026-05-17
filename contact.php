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