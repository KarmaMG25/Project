<?php
session_start();
require_once "../include/db.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Fetch all products
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop | Products</title>
    <link href="../Style/user_login.css" rel="stylesheet">
    <style>
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }
        .product-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 12px;
            background: #fff;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        .product-card img {
            max-width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-card h3 {
            margin: 10px 0 5px;
        }
        .product-card p {
            margin: 5px 0;
        }
        .product-card form {
            margin-top: 10px;
        }
        .product-card button {
            background-color: #333;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .product-card button:hover {
            background-color: #555;
        }
        nav {
            text-align: center;
            margin-top: 20px;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <h1>All Products - Angus & Coote</h1>
        </div>
    </header>

    <nav>
        <a href="main.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="orders.php">My Orders</a>
        <a href="wishlist.php">Wishlist</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="products-container">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-card">
                <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <<form action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">

                <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>">Add to Cart</a>

                <a href="remove_from_cart.php?cart_id=<?php echo $row['id']; ?>" onclick="return confirm('Remove this item?');">Remove</a>

                <a href="add_to_wishlist.php?id=<?php echo $row['id']; ?>">Wishlist</a>
                </form>

            </div>
        <?php endwhile; ?>
    </div>

    <footer>
        <p style="text-align:center;">&copy; 2025 Angus & Coote. All rights reserved.</p>
    </footer>

</body>
</html>
