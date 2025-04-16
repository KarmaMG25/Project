<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    // Check current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current, $hashedPassword)) {
        if ($new === $confirm) {
            $newHashed = password_hash($new, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->bind_param("si", $newHashed, $userId);
            $update->execute();
            $message = "Password updated successfully!";
        } else {
            $message = "New passwords do not match!";
        }
    } else {
        $message = "Current password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Settings</title>
</head>
<body>
    <h2>Change Password</h2>
    <p style="color:<?= strpos($message, 'success') ? 'green' : 'red' ?>;"><?= $message ?></p>

    <form method="post" action="">
        <label>Current Password:</label><br>
        <input type="password" name="current_password" required><br><br>

        <label>New Password:</label><br>
        <input type="password" name="new_password" required><br><br>

        <label>Confirm New Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Update Password</button>
    </form>
</body>
</html>
