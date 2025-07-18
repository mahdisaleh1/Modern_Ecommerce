<?php
include '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
} else {
    $id = $_SESSION['user_id'];
}
$query = "SELECT * FROM customers WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
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
    <title>Orders - Deems</title>
</head>

<body>
    <!-- HEADER SECTION -->
    <header class="navbar">
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="logo">
            <a href="../index.php">Deems</a>
        </div>
        <nav class="nav-links">
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="./userdashboard.php">Dashboard</a></li>
                <li><a href="./profileuser.php">Profile</a></li>
                <li><a href="../shop/shoplist.php">Shop</a></li>
                <li><a href="../shop/cartlist.php">Cart</a></li>
                <li><a href="../contactus.php">Support</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="user-icons">
            <a href="./profileuser.php"><i class="bx bx-user"></i></a>
            <a href="../shop/cartlist.php"><i class="bx bx-cart"></i></a>
        </div>
    </header>

    <!--FOR MOBILE PHONES ONLY-->
    <div class="nav-overlay" id="nav-overlay">
        <button class="close-btn" id="close-btn">X</button>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="./userdashboard.php">Dashboard</a></li>
            <li><a href="./profileuser.php">Profile</a></li>
            <li><a href="../shop/shoplist.php">Shop</a></li>
            <li><a href="../shop/cartlist.php">Cart</a></li>
            <li><a href="../contactus.php">Support</a></li>
            <li><a href="./logout.php">Logout</a></li>
            <li><a href="./profileuser.php"><i class="bx bx-user"></i></a>
                <a href="../shop/cartlist.php"><i class="bx bx-cart"></i></a>
            </li>
        </ul>
    </div>

    <form action="orders.php" method="post">
        <div class="orderscontainer">
            <h2>Orders History</h2>
            <div class="cards">
                <?php
                $result = $con->query("SELECT * FROM orders WHERE user_id = '$id'");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<h4>Order ID: #</h4>";
                        echo "<p>" . $row['order_id'] . "</p><br>";
                        echo "<h4>Date: </h4> ";
                        echo "<p>" . $row['order_date'] . "</p><br>";
                        echo "<h4>TotalAmount: $</h4>";
                        echo "<p>" . number_format($row['total_amount'] + 4, 2) . "</p><br>";
                        //echo "<p>" .$row['total_amount']. "</p><br>";
                        echo "<h4>Status: </h4> ";
                        echo "<p>" . $row['status'] . "</p><br>";
                        echo "<a href='./orderdetails.php?order_id=" . $row['order_id'] . "'>Check details</a>";
                        echo "</div>";
                    }
                } ?>
                <h2>Customize Orders History</h2>
                <?php
                $query = "SELECT * FROM customorder WHERE emailaddress = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $customer['email']);
                $stmt->execute();
                $result = $stmt->get_result();
                $order_data = $result->fetch_assoc();
                echo "<div class='card'>";
                echo "<h4>Order ID: #</h4>";
                echo "<p>" . $order_data['id'] . "</p><br>";
                echo "<h4>Date: </h4> ";
                echo "<p>" . $order_data['date'] . "</p><br>";
                
                //echo "<p>" .$row['total_amount']. "</p><br>";
                echo "<h4>Status: </h4> ";
                echo "<p>" . $order_data['status'] . "</p><br>";
                //echo "<a href='./orderdetails.php?order_id=" . $order_data['id'] . "'>Check details</a>";
                echo "</div>";


                ?>
            </div>
        </div>
    </form>

    <script src="../js/script.js"></script>

</body>

</html>