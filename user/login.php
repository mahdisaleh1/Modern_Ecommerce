<?php
include '../config.php';
session_start();
if (isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ./userdashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $un = $_POST['email'];
    $password = $_POST['psw'];
    $hashed_password = md5($password);
    $stmt = "SELECT * FROM customers WHERE email = '$un' AND status = 'activated'";
    $result = mysqli_query($con, $stmt);
    if ($result) {
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_fname'] = $user['fname'];
            $_SESSION['user_lname'] = $user['lname'];
            $_SESSION['user_password'] = $user['password'];
            $_SESSION['user_phone'] = $user['phone'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_address'] = $user['address'];
            if ($password !== $user['password']) {
                //AND password = '$password'
                echo '<script>alert("Incorrect password!" );</script>';
                header("Refresh:0.11; url=./login.php");
                session_unset();
                session_destroy();
            } else {
                if ($user['role'] === 'admin') {
                    echo '<script>alert("Welcome ' . $user['fname'] . '! You entered using an Admin Account!" );</script>';
                    header("Refresh:0.11; url=../admin/admindashboard.php");
                } else {
                    echo '<script>alert("Welcome ' . $user['fname'] . '")</script>';
                    header("Refresh:0.11; url=./userdashboard.php");
                }
            }
        } else {
            echo '<script>alert("No account with this email!" );</script>';
            header("Refresh:0.11; url=./login.php");
            session_unset();
            session_destroy();
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
    <link rel="stylesheet" href="../css/user.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Login page - Deems</title>
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
                <li><a href="../shop/categorylist.php">Category</a></li>
                <li><a href="../shop/shoplist.php">Shop</a></li>
                <li><a href="../shop/customize.php">Customize Yours</a></li>
                <li><a href="../contactus.php">Contact us</a></li>
            </ul>
        </nav>
        <div class="user-icons">
            <a id="search-button" href="#"><i class="bx bx-search"></i></a>
            <a href="./login.php"><i class="bx bx-user"></i></a>
            <a href="../shop/cartlist.php"><i class="bx bx-cart"></i></a>
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
            <li><a href="../shop/categorylist.php">Category</a></li>
            <li><a href="../shop/shoplist.php">Shop</a></li>
            <li><a href="../shop/customize.php">Customize</a></li>
            <li><a href="../contactus.php">Contact us</a></li>
            <li><a href="./login.php"><i class="bx bx-user"></i></a>
                <a href="../shop/cartlist.php"><i class="bx bx-cart"></i></a>
            </li>

        </ul>
    </div>



    <!-- LOGIN SECTION-->
    <div class="container">
        <div class="login-form">
            <form action="login.php" method="post">

                <div class="cllin">
                    <h1>Login</h1>
                    <p>Create Account? Click <a href="./signup.php">here</a>!</p>
                    <label>Email Address</label>
                    <input type="email" placeholder="Enter email" name="email" class="email" required>
                    <label>Password</label>
                    <input type="password" placeholder="Enter your password" name="psw" class="loginpsw" required>
                    <a href="./forgetpassword.php">Forget password?</a>
                </div>

                <div class="buttons">
                    <a href="../index.php" class="cancel">Cancel</a>
                    <button type="submit" name="submit" class="loginbtn">Login</button>
                </div>
            </form>
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
    <script src="../js/script.js"></script>
</body>

</html>