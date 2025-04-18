<?php
session_start();
include_once("../include/db.php");

// Fetch categories and subcategories for filters
$categories = $conn->query("SELECT * FROM categories");
$subcategories = $conn->query("SELECT * FROM subcategories");

// Build WHERE clause based on filters
$where = "WHERE 1";
if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}
if (!empty($_GET['category'])) {
    $cat = (int)$_GET['category'];
    $where .= " AND p.category_id = $cat";
}
if (!empty($_GET['subcategory'])) {
    $subcat = (int)$_GET['subcategory'];
    $where .= " AND p.subcategory_id = $subcat";
}

// Fetch filtered products
$products = $conn->query("SELECT p.*, c.name AS category, s.name AS subcategory 
                          FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          LEFT JOIN subcategories s ON p.subcategory_id = s.id 
                          $where");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .filter-form {
            margin-bottom: 20px;
        }

        .product-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .product-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card h3 {
            margin-top: 10px;
        }

        .product-card p {
            margin: 5px 0;
        }

        .product-card button {
            background-color: #333;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
            margin: 5px;
        }

        .product-card button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Browse Products</h2>

    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search products..." 
               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">

        <select name="category">
            <option value="">All Categories</option>
            <?php while($cat = $categories->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>" 
                    <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="subcategory">
            <option value="">All Subcategories</option>
            <?php while($sub = $subcategories->fetch_assoc()): ?>
                <option value="<?= $sub['id'] ?>" 
                    <?= (isset($_GET['subcategory']) && $_GET['subcategory'] == $sub['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sub['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Filter</button>
    </form>

    <?php if ($products->num_rows > 0): ?>
        <div class="product-list">
            <?php while($row = $products->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                    <p>Category: <?= htmlspecialchars($row['category']) ?> | 
                       Subcategory: <?= htmlspecialchars($row['subcategory']) ?></p>
                    <p>Price: $<?= number_format($row['price'], 2) ?></p>

                    <!-- Add to Cart -->
                    <a href="add_to_cart.php?product_id=<?= $row['id'] ?>">
                        <button>Add to Cart</button>
                    </a>

                    <!-- Add to Wishlist -->
                    <a href="add_to_wishlist.php?id=<?= $row['id'] ?>">
                        <button>Add to Wishlist</button>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</body>
</html>
