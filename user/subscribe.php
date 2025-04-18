<?php
include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        // Check for duplicate
        $check = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            // Insert new subscriber
            $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "<script>alert('Subscribed successfully!'); window.history.back();</script>";
            } else {
                echo "<script>alert('Something went wrong.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('You are already subscribed.'); window.history.back();</script>";
        }
    }
}
?>
