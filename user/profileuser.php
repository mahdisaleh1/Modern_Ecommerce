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
            $_SESSION['user_city'] = $user['city'];
            $fname = $_SESSION['user_fname'];
            $lname = $_SESSION['user_lname'];
            $email = $_SESSION['user_email'];
            $phone = $_SESSION['user_phone'];
            $city = $_SESSION['user_city'];
            $address = $_SESSION['user_address'];
            $password = $_SESSION['user_password'];
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fnames = $_POST['fname'];
    $lnames = $_POST['lname'];
    $emails = $_POST['email'];
    $phones = $_POST['phonenumb'];
    $addresss = $_POST['address'];
    $citys = $_POST['cityadd'];
    $passwords = $_POST['psw'];
    if($fname != $fnames || $lname != $lnames || $email != $emails || $phone != $phones || $address != $addresss || $city != $citys || $password != $passwords){
        $id = $user['id'];
        $sql = "UPDATE customers SET email = '$emails', fname = '$fnames', lname = '$lnames', phone = '$phones', address = '$addresss', city = '$citys', password = '$passwords' WHERE id = '$id'";
        if ($con->query($sql) === TRUE) {
            echo '<script>alert("Changes saved successfuly! Please login again." );</script>';
            header("Refresh:0.11; url=./logout.php");
        }
        
    }
    else {
        echo '<script>alert("No changes has been occured!" );</script>';
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
    <link rel="stylesheet" href="../css/profileuser.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>My profile - Deems</title>
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
            <li><a href="./userdashboard.php">Dashboard</a></li>
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

    <form action="profileuser.php" method="post">
        <div class="container">
            <h1>Welcome to <?php echo $_SESSION['user_fname']; ?>'s profile</h1>
            <div class="profilecontainer">
                <h3>Personal Information</h3>
                <div class="personalinfo">
                    <label>Email Address:</label>
                    <input type="email" placeholder="Enter your email address" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <div class="divname">
                        <label>First Name:</label>
                        <input type="text" placeholder="Enter your first name" name="fname" value="<?php echo htmlspecialchars($fname); ?>" required>
                        
                        <label>Last Name:</label>
                        <input type="text" placeholder="Enter your last name" name="lname" value="<?php echo htmlspecialchars($lname); ?>" required>
                    </div>
                    <div class="divtwo">
                        <label>Phone Number:</label>
                        <input type="number" placeholder="Enter your phone number" name="phonenumb" value="<?php echo htmlspecialchars($phone); ?>" required>
                        <label>Password:</label>
                        <input type="password" placeholder="Enter your password" name="psw" value="<?php echo htmlspecialchars($password); ?>" required onfocus="this.type='text'" 
                        onblur="this.type='password'">
                    </div>
                </div>
                <div class="addressinfo">
                    <h3>Address Settings</h3>
                    <label>Address:</label>
                    <input type="text" placeholder="Enter your address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
                    <label>City:</label>
                    <input type="text" placeholder="Enter the city" name="cityadd" value="<?php echo htmlspecialchars($city); ?>" required>
                </div>
            </div>
            <div class="buttons">
                <button type="submit" class="submitbtn">Apply Changes</button>
            </div>
        </div>
    </form>
    
    <script src="../js/script.js"></script>

</body>

</html>