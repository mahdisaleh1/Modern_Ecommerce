<?php
include '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
} else {
    $id = $_SESSION['user_id'];
}
$order_id = $_GET['order_id'];
$query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order_data = $result->fetch_assoc();
$order_date = $order_data['order_date'];
$order_status = $order_data['status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/ordersuser.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Order Details - Deems</title>
</head>

<body>
    <!-- HEADER SECTION -->
    <header class="navbar">
        <div class="user-icons">
            <a href="./orders.php" class="arrowbxtwo"><i class="bx bx-arrow-back"></i></a>
            <a href="./orders.php">Back to orders</a>
        </div>
        <div class="logo">
            <a href="../index.php">Deems</a>
        </div>
        <nav class="nav-links">
            <li><a href="./logout.php">Logout</a></li>
        </nav>
    </header>


    <form action="orderdetails.php" method="post">
        <div class="ordercontainer">
            <h2>Order Details</h2>
            <?php
            $subtotal = 0;
            $query = "SELECT * FROM order_items WHERE order_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $subtotal += $row['subtotal'];
                    $query = "SELECT * FROM products WHERE id = ?";
                    $stmtt = $con->prepare($query);
                    $stmtt->bind_param("i", $row['product_id']);
                    $stmtt->execute();
                    $resultt = $stmtt->get_result();
                    $product = $resultt->fetch_assoc();  
                    echo "<div class='orderitems'>";
                    echo "<div class='order-item'>";
                    echo "<img src='../uploads/" . $product["image"] . "' alt='" . $product["name"] . "'>";
                    echo "<div class='details'>";
                    echo "<p><strong> Name: </strong> " . $product['name'] . "</p>";
                    $queryy ="SELECT * FROM productvariants WHERE product_variant_id = ?";
                    $stmttt = $con->prepare($queryy);
                    $stmttt->bind_param("i", $row['variant_id']);
                    $stmttt->execute();
                    $resulttt = $stmttt->get_result();
                    $variants = $resulttt->fetch_assoc();  
                    //echo "<p> Size: " . $variants['value'] . "</p>";
                    echo "<p><strong> Size:</strong> " . $variants['value'] . "</p>";
                    echo "<p class='price'> $" . $row['price_per_unit'] . "</p>";
                    echo "</div>";
                    echo "<p><strong>Qty: </strong>" . $row['quantity'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No orders";
            }
            ?>
            <!--<div class="order-item">
                    <img src="../images/deemsproduct.JPG">
                    <div class="details">
                        <p><strong>Tshirt New Collection</strong></p>
                        <p>Size Purchased</p>
                        <p class="price">$20.00</p>
                    </div>
                    <p>Qty: 1</p>
                </div>-->
            <div class="order-summary">
                <p>Sub-total: <span>$<?php echo number_format($subtotal, 2); ?></span></p>
                <p>Shipping: <span>$4.00</span></p>
                <p>Total: <span><?php echo number_format($subtotal + 4, 2); ?></span></p>
                <p>Date order: <span><?php echo $order_date; ?></span></p>
                <p>Status: <span class="status"><?php echo $order_status; ?></span></p>
            </div>
        </div>
    </form>

    <script src="../js/script.js"></script>

</body>
<style>
    @media (max-width: 768px) {
        .nav-links {
            visibility: hidden;
        }

        .logo a {
            right: 100%;
        }
    }
</style>

</html>