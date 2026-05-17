<?php
include("db.php");

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (username,email,password)
                  VALUES ('$username','$email','$password')");

    header("Location: login.php");
}
?>

<form method="POST">
    <input name="username" placeholder="Username" required>
    <input name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="register">Register</button>
</form>