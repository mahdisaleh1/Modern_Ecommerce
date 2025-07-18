<?php
include '../config.php';
session_start();

//Get the data from cart[]
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_quantity"])) {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    if ($quantity > 0) {
        $_SESSION["cart"][$product_id]["quantity"] = $quantity;
    } else {
        unset($_SESSION["cart"][$product_id]);
    }
}

// Handle product removal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_product"])) {
    $product_id = $_POST["product_id"];
    unset($_SESSION["cart"][$product_id]);
}

//check if the user is logged in or no
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['user_email']) && isset($_SESSION['user_fname']) && isset($_SESSION['user_lname']) && isset($_SESSION['user_phone']) && isset($_SESSION['user_address'])) {
        $user_id = $_SESSION['user_id'];
        $email = $_SESSION['user_email'];
        $fname = $_SESSION['user_fname'];
        $lname = $_SESSION['user_lname'];
        //$city = $_SESSION['user_city'];
        $phone = $_SESSION['user_phone'];
        $address = $_SESSION['user_address'];
        $comment = isset($_POST['commentsinfo']) ? $_POST['commentsinfo'] : '';
    }
}

//Get data of the customer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['emailadd'];
        $phone = $_POST['phonenum'];
        $city = $_POST['city'];
        $address = $_POST['addressinfo'];
        $apartment = $_POST['addressmoreinfo'];
        $comment = $_POST['commentsinfo'];

        $customer_query = "INSERT INTO customers (fname, lname, email, phone, city, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($customer_query);
        //$full_address = $address . ', ' . $apartment . ', ' . $city;
        $stmt->bind_param("ssssss", $fname, $lname, $email, $phone, $city, $address);
        $stmt->execute();
        $user_id = $stmt->insert_id;
    }

    //Calculate total
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $subtotal = isset($product['variant_price'])
            ? $product['variant_price'] * $product['quantity']
            : $product['price'] * $product['quantity'];
        $total_amount += $subtotal;
    }

    // Insert order
    $order_query = "INSERT INTO orders (user_id, order_date, total_amount, comment, status) VALUES (?, NOW(), ?, ?, 'Pending')";
    $stmt = $con->prepare($order_query);
    $stmt->bind_param("ids", $user_id, $total_amount, $comment);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    // Insert order items 
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $variant_id = isset($product['variant_id']) ? $product['variant_id'] : NULL;
        $price_per_unit = isset($product['variant_price']) ? $product['variant_price'] : $product['price'];
        $subtotal = $price_per_unit * $product['quantity'];

        $order_item_query = "INSERT INTO order_items (order_id, product_id, variant_id, quantity, price_per_unit, subtotal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($order_item_query);
        $stmt->bind_param("iiiidd", $order_id, $product_id, $variant_id, $product['quantity'], $price_per_unit, $subtotal);
        $stmt->execute();
    }

    // Clear cart after order submission
    unset($_SESSION['cart']);
    //header("Location: order_confirmation.php?order_id=" . $order_id);
    header("Location: ./afterorder.php?order_id=" . $order_id);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cartlist.css">
    <link rel="stylesheet" href="../css/checkout.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Checkout - Deems</title>
</head>

<body>
    <!-- HEADER SECTION -->
    <header class="navbar">
        <div class="logo">
            <a href="index.php">Deems</a>
        </div>
        <div class="user-icons">
            <a href="./cartlist.php"><i class="bx bx-cart"></i></a>
        </div>
    </header>

    <!-- Cart SECTION -->
    <form action="checkoutcart.php" method="post">
        <section class="section cart">
            <div class="checkout-container">
                <div class="form-section">
                    <div class="cartheader">
                        <h2>Delivery Information</h2>
                        <a href="../user/login.php">Login</a>
                    </div>

                    <select>
                        <option>Lebanon</option>
                    </select>
                    <?php
                    if (!isset($_SESSION['user_id'])): ?>
                        <div class="input-row">
                            <input type="text" placeholder="First name" name="fname" value="" required>
                            <input type="text" placeholder="Last name" name="lname" value="" required>
                        </div>
                        <input type="text" placeholder="Email Address" name="emailadd" value="" required>
                        <input type="number" placeholder="Phone number" name="phonenum" value="" required>
                        <input type="text" placeholder="City" name="city" value="" required>
                        <input type="text" placeholder="Address" name="addressinfo" value="" required>
                    <?php else: ?>
                        <div class="input-row">
                            <input type="text" placeholder="First name" name="fname" value="<?php echo htmlspecialchars($fname) ?>" required>
                            <input type="text" placeholder="Last name" name="lname" value="<?php echo htmlspecialchars($lname) ?>" required>
                        </div>
                        <input type="text" placeholder="Email Address" name="emailadd" value="<?php echo htmlspecialchars($email) ?>" required>
                        <input type="number" placeholder="Phone number" name="phonenum" value="<?php echo htmlspecialchars($phone) ?>" required>
                        <input type="text" placeholder="City" name="city" value="" required>
                        <input type="text" placeholder="Address" name="addressinfo" value="<?php echo htmlspecialchars($address) ?>" required>
                    <?php endif; ?>
                    <input type="text" placeholder="Apartment, suite, etc. (optional)" name="addressmoreinfo">
                    <input type="number" placeholder="Postal code (optional)">
                    <textarea placeholder="Comment here or more info" name="commentsinfo"></textarea>
                    <div class="shippingdiv">
                        <h2>Shipping Method</h2>
                        <select>
                            <option>Standard Delivery - $4.00</option>
                        </select>
                    </div>
                    <div class="paymentdiv">
                        <h2>Payemnt Method</h2>
                        <select>
                            <option>Cash on delivery (COD)</option>
                        </select>
                    </div>
                    <div class="billingaddressdiv">
                        <h2>Billing address</h2>
                        <select>
                            <option>Same as shipping address</option>
                        </select>
                    </div>

                    <div class="saveinfocheck">
                        <input type="checkbox" id="saveinfo1" name="saveinfo1" checked>
                        <label for="saveinfo1">Save info for next order?</label>
                    </div>
                    <br>
                    <button>Confirm order</button>
                </div>

                <div class="cart-section">
                    <h2>Order Summary</h2>
                    <div class="cart-item">
                        <?php
                        if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
                            $total = 0;
                            $count = 0;
                            foreach ($_SESSION["cart"] as $product_id => $product) {
                                $variant_query = "SELECT * FROM productvariants WHERE product_id = ? AND variant_id = '2'";
                                $stmt = $con->prepare($variant_query);
                                $stmt->bind_param("i", $product_id);
                                $stmt->execute();
                                $variants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                if (count($variants) > 0) {
                                    $count++;
                                    $subtotal = $product["variant_price"] * $product["quantity"];
                                    $total += $subtotal;
                                    echo "<div class='cart-row'>";
                                    echo "<div class='cart-item-info'>";
                                    echo "<img src='../uploads/" . $product["image"] . "' alt='" . $product["name"] . "'>";
                                    echo "<div>";
                                    echo "<p>" . $product["name"] . "</p>";
                                    echo "<p>Size: " . htmlspecialchars($product['variant_value']) . "</p>";
                                    echo "<p>Price: $" . number_format($product['variant_price'], 2) . "</p>"; // Price of one piece
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='cart-item-subtotal'>";
                                    echo "<p>Qty: " . $product["quantity"] . "</p>";
                                    echo "<p>Subtotal: $" . number_format($subtotal, 2) . "</p>"; // Subtotal for this row
                                    echo "</div>";
                                    echo "</div>";
                                } else {
                                    $count++;
                                    $subtotal = $product["price"] * $product["quantity"];
                                    $total += $subtotal;
                                    echo "<div class='cart-row'>";
                                    echo "<div class='cart-item-info'>";
                                    echo "<img src='../uploads/" . $product["image"] . "' alt='" . $product["name"] . "'>";
                                    echo "<div>";
                                    echo "<p>" . $product["name"] . "</p>";
                                    //echo "<p>Size: " . htmlspecialchars($product['variant_value']) . "</p>";
                                    echo "<p>Price: $" . number_format($product['price'], 2) . "</p>"; // Price of one piece
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='cart-item-subtotal'>";
                                    echo "<p>Qty: " . $product["quantity"] . "</p>";
                                    echo "<p>Subtotal: $" . number_format($subtotal, 2) . "</p>"; // Subtotal for this row
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="order-summary">
                        <?php
                        echo "<p>Subtotal: $" . number_format($total, 2) . "</p>";
                        echo "<p>Shipping: $4.00</p>";
                        echo "<p class='total'>Total: $" . number_format($total + 4, 2) . "</p>";
                        ?>
                    </div>
                </div>
            </div>


        </section>
    </form>

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
    <script src="../js/script.js"></script>
</body>
<script>

</script>
<style>

</style>

</html>