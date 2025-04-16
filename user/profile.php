<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $phone, $userId);
    $stmt->execute();

    $success = "Profile updated successfully!";
}

// Fetch user info
$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
</head>
<body>
    <h2>My Profile</h2>

    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="post" action="">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"><br><br>

        <label>Email (readonly):</label><br>
        <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
