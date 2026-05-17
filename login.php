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