<?php
include '../config.php';
session_start();
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$products_per_page = 5;
/*$products_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //retreiev page number from query
$page = max($page, 1); //at least 1 page
$offset = ($page - 1) * $products_per_page; //calculate offset for the sql query in current page
$total_products_query = "SELECT COUNT(*) AS total FROM product";
$total_products_result = $con->query($total_products_query);
$total_products = $total_products_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $products_per_page);*/
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); //at least 1 page
$total_pages = $products_per_page;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/shop.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Shop Page - Deems</title>
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
            <li><a href="../shop/categorylist.php">Category</a></li>
            <li><a href="../shop/shoplist.php">Shop</a></li>
            <li><a href="../shop/customize.php">Customize</a></li>
            <li><a href="../contactus.php">Contact us</a></li>
            <li><a href="../user/login.php"><i class="bx bx-user"></i></a>
                <a href="./cartlist.php"><i class="bx bx-cart"></i></a>
            </li>

        </ul>
    </div>



    <!-- Product SECTION-->
    <div class="container">
        <form action="shoplist.php" method="post" id="product-container">
            <section class="products">
                <div class="title">
                    <h1>Products</h1>
                </div>
                <div class="product-center">
                    <?php
                    if ($category_id) {
                        $resultt = $con->query("SELECT * FROM category WHERE id=$category_id");
                        if (!$category_id == null) {
                            if (mysqli_num_rows($resultt) === 1) {
                                $cat = mysqli_fetch_assoc($resultt);
                                $_SESSION['cat_name'] = $cat['name'];
                                $catname = $cat['name'];
                            } else {
                                echo "hello NO";
                                $category_id = null;
                            }
                        } else {
                            $category_id = null;
                        }
                        $result = $con->query("SELECT * FROM products WHERE category = '$category_id' AND status='available' ");
                    } else {
                        //$result = $con->query("SELECT * FROM products WHERE status='available' LIMIT $products_per_page OFFSET $offset");
                        $result = $con->query("SELECT * FROM products WHERE status='available'");
                    }
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='product-item'>";
                            echo "<div class='overlay'>";
                            echo "<a href='./productdetails.php?product_id=" . $row['id'] . "'><img src='../uploads/" . $row["image"] . "' alt='" . $row["name"] . "'></a>";
                            echo "</div>";
                            echo "<div class='product-info'>";
                            echo "<a href='./productdetails.php?product_id=" . $row['id'] . "'>" . $row['name'] . "</a>";
                            echo "<h4> $" . $row['price'] . "</h4>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </section>
        </form>
    </div>
    <!-- PAGINATION SECTION-->
    <section class='pagination'>
        <div class='container'>
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $page ? 'class="active"' : '';
                echo "<span><a href='shop.php?page=$i' $active>$i</a></span>";
            } ?>

        </div>
    </section>


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
    @media screen and (max-width: 768px) {
        
        .container {
            margin-top: 15px;
        }
    }
</style>

</html>