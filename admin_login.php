<?php
session_start();
$conn = new mysqli("localhost", "root", "", "coaching_web");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$username = $_POST['username'];
$password = $_POST['password'];

// Hardcoded admin list
$admins = [
    'deki' => '987668',
    'madan' => '987661',
    'yeshi' => '987667'
];

if (isset($admins[$username]) && $admins[$username] === $password) {
    $_SESSION['admin'] = $username;
    header("Location: admin_dashboard.php");
} else {
    echo "Invalid admin credentials.";
}
?>