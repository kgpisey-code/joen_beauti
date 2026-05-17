<?php
$conn = new mysqli("localhost", "root", "", "joen_beauti");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>