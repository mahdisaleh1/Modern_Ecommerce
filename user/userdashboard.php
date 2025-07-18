<?php
include '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
} else {
    $id = $_SESSION['user_id'];
    $stmt = "SELECT * FROM customers WHERE id = '$id'";
    $result = mysqli_query($con, $stmt);
    if ($result) {
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_fname'] = $user['fname'];
            $_SESSION['user_lname'] = $user['lname'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/userdashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>My Dashboard - Deems</title>
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
                <li><a href="./profileuser.php">Profile</a></li>
                <li><a href="./orders.php">Orders</a></li>
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
            <li><a href="./profileuser.php">Profile</a></li>
            <li><a href="./orders.php">Orders</a></li>
            <li><a href="../shop/shoplist.php">Shop</a></li>
            <li><a href="../shop/cartlist.php">Cart</a></li>
            <li><a href="../contactus.php">Support</a></li>
            <li><a href="./logout.php">Logout</a></li>
            <li><a href="./profileuser.php"><i class="bx bx-user"></i></a>
                <a href="../shop/cartlist.php"><i class="bx bx-cart"></i></a>
            </li>
        </ul>
    </div>

    <form action="userdashboard.php" method="post">
        <div class="container">
            <h1>Welcome, <?php echo $_SESSION['user_fname']. " ". $_SESSION['user_lname']; ?></h1>
            <div class="cards">
                <div class="card">
                    <h3>Orders</h3>
                    <p><a href="./orders.php">View your order history</a></p>
                    <a href="./orders.php"><button type="button">View Orders</button></a>
                </div>
                <div class="card">
                    <h3>Profile</h3>
                    <p><a href="./profileuser.php">View and manage your profile</a></p>
                    <a href="./profileuser.php"><button type="button">View Profile</button></a>
                </div>
                <div class="card">
                    <h3>Cart</h3>
                    <p><a href="../shop/shoplist.php">Check items in your cart</a></p>
                    <a href="../shop/cartlist.php"><button type="button">View Cart</button></a>
                </div>
            </div>
        </div>
    </form>
    <div class="logoimage">
        
    </div>
    <script src="../js/script.js"></script>

</body>

</html>