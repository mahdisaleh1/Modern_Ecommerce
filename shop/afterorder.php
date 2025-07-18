<?php
include '../config.php';
session_start();

// Check if order ID is set
if (!isset($_GET['order_id'])) {
    header("Location: index.php"); // Redirect if no order ID is provided
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $con->prepare($order_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch order items
$items_query = "SELECT oi.*, p.name, p.image 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?";
$stmt = $con->prepare($items_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/afterorder.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Order Confirmation - Deems</title>
</head>

<body>
    <header class="navbar">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="logo">
            <a href="index.php">Deems</a>
        </div>
        <nav class="nav-links">
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="./categorylist.php">Category</a></li>
                <li><a href="./shoplist.php">Shop</a></li>
                <li><a href="./customize.php">Customize Yours</a></li>
                <li><a href="../contactus.php">Contact us</a></li>
            </ul>
        </nav>
        <div class="user-icons">
            <a id="search-button" href="#"><i class="bx bx-search"></i></a>
            <a href="../user/login.php"><i class="bx bx-user"></i></a>
            <a href="./cartlist.php"><i class="bx bx-cart"></i></a>
        </div>
        <div id="search-overlay" class="overlayy">
            <div class="search-container">
                <input type="text" id="search-input" class="searchinp" placeholder="Search...">
                <button id="close-search" class="closesearchbar">X</button>
            </div>
            <div id="search-results">
                <div class="products">
                    <div id="product-list">

                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--FOR MOBILE PHONES ONLY-->
    <div class="nav-overlay" id="nav-overlay">
        <button class="close-btn" id="close-btn">X</button>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="./categorylist.php">Category</a></li>
            <li><a href="./shoplist.php">Shop</a></li>
            <li><a href="./customize.php">Customize</a></li>
            <li><a href="../contactus.php">Contact us</a></li>
            <li><a href="../user/login.php"><i class="bx bx-user"></i></a>
                <a href="./cartlist.php"><i class="bx bx-cart"></i></a>
            </li>

        </ul>
    </div>


    <div class="confirmation-container">
        <h1>🎉 Thank You for Your Order!</h1>
        <p>Your order has been successfully placed. Here are the details:</p>

        <div class="order-summary">
            <h2>Order Details</h2>
            <p><strong>Order Number:</strong> #<?php echo $order_id; ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
            <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount']+4, 2); ?></p>
            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
        </div>

        <div class="order-items">
            <h2>Items Ordered</h2>
            <?php foreach ($order_items as $item):
                if ($item['variant_id'] > 0) {
            ?>
                    <div class="item">
                        <img src="../uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div>
                            <p><?php echo $item['name']; ?></p>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <?php
                            $total = $item['subtotal'] + 4;
                            $itemvariantid = $item['variant_id'];
                            $itemproductid = $item['product_id'];
                            $variant_query = "SELECT * FROM productvariants WHERE product_id = ? AND product_variant_id = ?";
                            $stmt = $con->prepare($variant_query);
                            $stmt->bind_param("ii", $itemproductid, $itemvariantid);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $variant = $result->fetch_assoc();
                                $variant_value = $variant['value'];  // Fetch the 'value' field
                            } else {
                                $variant_value = 'N/A';  // Fallback if no variant is found
                            }
                            ?>
                            <p>Size: <?php echo $variant_value; ?></p>
                            <div class="totalcost">
                                <p>Subtotal: $<?php echo number_format($item['subtotal'], 2); ?></p>
                                
                            </div>

                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="item">
                        <img src="../uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                        <div>
                            <p><?php echo $item['name']; ?></p>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <div class="totalcost">
                                <p>Subtotal: $<?php echo number_format($item['subtotal'], 2); ?></p>
                                
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            <?php endforeach; ?>
        </div>

        <div class="actions">
            <a href="./shoplist.php" class="btn">🛒 Continue Shopping</a>
            <!--<a href="./orderdetails.php?order_id=<?php echo $order_id; ?>" class="btn">📄 View Order Details</a>-->
        </div>
    </div>

    <!-- FOOTER SCTION-->
    <footer class="footer">
        <div class="divfooter">
            <form method="post" action="index.php">
                <div class="contact Footer">
                    <input type="email" class="emailinputfooter" placeholder="Email" required>
                    <button class="sendemailbtn">Send</button>
                </div>
            </form>
            <div class="informations">
                <p>@2025 Deems Copyrights</p>
                <p>Deems Crochet</p>
            </div>
            <div class="icons">
                <a href="https://www.instagram.com/deems.crochet/"><i class="bx bxl-instagram"></i></a>
                <a href="#"><i class="bx bxl-facebook-square"></i></a>
                <a href="#"><i class="bx bxl-whatsapp"></i></a>
                <a href="#"><i class="bx bxl-tiktok"></i></a>
            </div>
        </div>
    </footer>
</body>
<script src="../js/script.js"></script>
</html>