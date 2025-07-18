<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/contactus.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="./images/icon.png" type="image/x-icon">
    <title>Contact us - Deems </title>
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
            <a href="./index.php">Deems</a>
        </div>
        <nav class="nav-links">
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./shop/categorylist.php">Category</a></li>
                <li><a href="./shop/shoplist.php">Shop</a></li>
                <li><a href="./shop/customize.php">Customize Yours</a></li>
                <li><a href="./contactus.php">Contact us</a></li>
            </ul>
        </nav>
        <div class="user-icons">
            <a id="search-button" href="#"><i class="bx bx-search"></i></a>
            <a href="./user/login.php"><i class="bx bx-user"></i></a>
            <a href="./shop/cartlist.php"><i class="bx bx-cart"></i></a>
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
            <li><a href="./index.php">Home</a></li>
            <li><a href="./shop/categorylist.php">Category</a></li>
            <li><a href="./shop/shoplist.php">Shop</a></li>
            <li><a href="./shop/customize.php">Customize</a></li>
            <li><a href="./contactus.php">Contact us</a></li>
            <li><a href="./user/login.php"><i class="bx bx-user"></i></a>
                <a href="./shop/cartlist.php"><i class="bx bx-cart"></i></a>
            </li>

        </ul>
    </div>



    <!-- Contact SECTION-->
    <div class="contact-container">
        <div class="contactdiv">
            <h1>Contact Us</h1>
            <p>We’d love to hear from you! Whether you have questions about our crochet bags,
                custom orders, or anything else, we’re here to help. Feel free to reach out,
                and we’ll get back to you as soon as we can.</p>
            <div class="info-row">
                <label>Email:</label>
                <span>example@gmail.com</span>
            </div>
            <div class="info-row">
                <label>Phone:</label>
                <span>+961 3 123 456</span>
            </div>
            <div class="info-row">
                <label>Business Hours</label>
                <span>24/7</span>
            </div>
            <p>Alternatively, use the contact form below to send us a message, and we’ll be in touch shortly!</p>
            <h4>Thank you for choosing to support unique, handcrafted creations!</h4>
            <form method="" action="">
                <div class="contactinfo">
                    <label>Name</label>
                    <input type="text" class="flname" name="flname" placeholder="Your name" >
                    <label>Email (required)</label>
                    <input type="email" name="email" placeholder="example@gmail.com" required>
                    <label>Phone Number (required)</label>
                    <input type="number" name="phonenb" placeholder="+96103123456" required>
                    <label>Message</label>
                    <input type="text" name="textmsg" placeholder="Write your comments (optional)">
                </div>
                <div class="buttons">
                    <a href="./index.php" class="cancel">Cancel</a>
                    <button type="submit">Submit</button>
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
    <script src="./js/script.js"></script>
</body>

</html>