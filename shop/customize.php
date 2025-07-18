<?php
include '../config.php';
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phonenb'];
    $messagehere = $_POST['informations'];
    $customer_query = "INSERT INTO customorder (firstname, lastname, emailaddress, phonenumber, messagecust, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt = $con->prepare($customer_query);
    //$full_address = $address . ', ' . $apartment . ', ' . $city;
    $stmt->bind_param("sssss", $fname, $lname, $email, $phone, $messagehere);
    //$stmt->execute();
    if ($stmt->execute()) {
        echo '<script>alert("ORDER INSERTED" );</script>';
        header("Location: ../index.php");
    } else {
        echo "Error executing statement ORDER : " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/customize.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Custom Order - Deems</title>
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



    <!-- Customize SECTION-->
    <div class="container">
        <div class="customize-section">
            <div class="title">
                <h1>Customize Yours</h1>
            </div>
            <div class="overlay">
                <img src="../images/heroimage.jpg" alt="customizimage">
            </div>
            <form action="customize.php" method="post">
                <div class="infoforcust">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <label>Fisrt Name</label>
                        <input type="text" name="fname" placeholder="First Name" value="" required>
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last Name" value="" required>
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="Email Address" value="" required>
                        <label>Phone Number</label>
                        <input type="number" name="phonenb" placeholder="Phone Number" value="" required>
                        <label>Message Here:</label>
                        <textarea placeholder="Write your message here" name="informations"></textarea>
                    <?php else: ?>
                        <label>Fisrt Name</label>
                        <input type="text" name="fname" placeholder="First Name" value="<?php echo htmlspecialchars($fname) ?>" required>
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last Name" value="<?php echo htmlspecialchars($lname) ?>" required>
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email) ?>" required>
                        <label>Phone Number</label>
                        <input type="number" name="phonenb" placeholder="Phone Number" value="<?php echo htmlspecialchars($phone) ?>" required>
                        <label>Message Here:</label>
                        <textarea placeholder="Write your message here" name="informations"></textarea>
                    <?php endif; ?>
                </div>
                <div class="buttons">
                    <a href="../index.php" class="cancelbtn">Cancel</a>
                    <button type="submit" name="submit" class="submitbtn">Submit</button>
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
<style>
    textarea {
        width: 100%;
        padding: 12px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        color: #333;
        background-color: #f9f9f9;
        transition: border 0.3s ease, box-shadow 0.3s ease;
    }
</style>

</html>