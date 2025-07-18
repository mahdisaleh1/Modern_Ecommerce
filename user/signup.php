<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $stmt = "SELECT id FROM customers WHERE email = '$email'";
    $result = mysqli_query($con, $stmt);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<script>alert("Please use a different email address!" );</script>';
            header("Refresh:0.11; url=./signup.php");
        } else {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $password = $_POST['psw'];
            $customer_query = "INSERT INTO customers (fname, lname, email, password, phone, address, date) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $con->prepare($customer_query);
            $stmt->bind_param("ssssis", $fname, $lname, $email, $password, $phone, $address);
            //$stmt->execute();
            if ($stmt->execute()) {
                echo '<script>alert("Customer account has been created!" );</script>';
                header("Refresh:0.11; url=./login.php");
            } else {
                echo "Error creating your account! Try again later.";
            }
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
    <title>Register - Deems</title>
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
            <form action="signup.php" method="post">
                <div class="cllin">
                    <h1>Register</h1>
                    <p>Already have an account? Click <a href="./login.php">here</a>!</p>
                    <!--<label>First Name</label>
                    <input type="text" name="fname" class="fname" placeholder="First Name" required>
                    <label>Last Name</label>
                    <input type="text" name="lname" class="lname" placeholder="Last Name" required>
                    <label>Email Address</label>
                    <input type="email" placeholder="Enter Email" name="email" class="email" required>
                    <label>Phone Number</label>
                    <input type="number" name="phone" class="phone" placeholder="Phone Number" required>
                    <label>Your Address</label>
                    <input type="text" name="address" class="address" placeholder="Address" required>
                    <label>Password</label>
                    <input type="password" placeholder="Enter your password" name="psw" class="loginpsw" required>
                    <label>Re-enter Password</label>
                    <input type="password" placeholder="Check password" name="psw" class="loginpsw" required>-->
                    <div class="input-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="Enter Email" name="email" class="email" required>
                    </div>
                    <div class="form-grid">
                        <div class="left-column">
                            <label>First Name</label>
                            <input type="text" name="fname" class="fname" placeholder="First Name" required>

                            <label>Last Name</label>
                            <input type="text" name="lname" class="lname" placeholder="Last Name" required>

                            <label>Phone Number</label>
                            <input type="number" name="phone" class="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="right-column">
                            <label>Your Address</label>
                            <input type="text" name="address" class="address" placeholder="Address" required>

                            <label>Password</label>
                            <input type="password" placeholder="Create Password" id="password" name="psw" class="loginpsw" required>

                            <label>Re-enter Password</label>
                            <input type="password" placeholder="Check password" id="repeatPassword" name="repeatpsw" class="loginpsw" required>

                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <a href="../index.php" class="cancel">Cancel</a>
                    <button type="submit" name="submit" class="loginbtn">Register</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#repeatPassword').on('input', function() {
                const password = $('#password').val();
                const repeatPassword = $(this).val();

                if (repeatPassword && password !== repeatPassword) {
                    $('#repeatPassword').css('border', '2px solid red');
                } else {
                    $('#repeatPassword').css('border', '1px solid #ccc');
                }
            });
        });
    </script>
</body>
<style>
    .container {
        height: auto;
        margin-bottom: 15px;
    }

    .login-form {
        height: auto;
        width: 100%;
        max-width: 60%;
    }


    @media (max-width:768px) {
        .container {
            margin-top: 115px;
            margin-bottom: 50px;
        }

        .login-form {
            height: auto;
            width: 100%;
            max-width: 95%;
        }

    }
</style>

</html>