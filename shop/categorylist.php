<?php
include '../config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Category List - Deems</title>
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



    <!-- Category SECTION-->
    <form action="./categorylist.php" method="post" >
        <section class="section category">
            <h2>Category</h2>
            <div class="cat-center">
                <!--<div class="category-item">
                    
                        <img src="../images/heroimage.jpg" alt="Category 1">
                        <div class="category-name">Category 1</div>
                    
                </div>
                 Category 2 
                <div class="category-item">
                    
                        <img src="../images/heroimage.jpg" alt="Category 2">
                        <div class="category-name">Category 2</div>
                    
                </div>
                <div class="category-item">
                    <a href="#">
                        <img src="../images/heroimage.jpg" alt="Category 3">
                        <div class="category-name">Category 3</div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#"><img src="../images/heroimage.jpg" alt="Category 4">
                        <div class="category-name">Category 4</div>
                    </a>
                </div>
                <div class="category-item">
                    <a href="#">
                        <img src="../images/heroimage.jpg" alt="Category 5">
                        <div class="category-name">Category 5</div>
                    </a>
                </div>-->
                <?php
                $result = $con->query("SELECT * FROM category");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        echo "<div class='category-item'>";
                        echo "<a href='./shoplist.php?category_id=" . $row['id'] . "'>";
                        //echo "<h2>" . $row['id'] . "</h2>";
                        echo "<img src='../uploads/" . $row["image"] . "' alt='" . $row["name"] . "' style='width:36.5rem;height:100%;'>";
                        echo "<div class='category-name'>";
                        echo $row['name'];
                        echo "</div>";
                        echo "</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<tr><td colspan='5'> No Products Found </td></tr>";
                }
                ?>
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
<style>
    .section.category {
        margin-top: 5%;
        text-align: center;
        padding: 3rem 2rem;
        height: auto;
    }

    .section.category h2 {
        font-size: 2rem;
        margin-bottom: 2rem;
        color: #333;
    }

    /* Categories Container */
    .cat-center {
        
        width: 100%;
        max-width: 100%;
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        /* Ensures it wraps on smaller screens */
    }

    /* Single Category Item */
    .category-item {
        position: relative;
        width: calc((100% - 40px) / 3);
        height: 350px;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        margin: auto;
    }

    .category-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .category-item .category-name a {
        text-decoration: none;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        text-align: center;
        padding: 10px 0;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 1.2rem;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .category-item:hover {
        transform: scale(1.05);
        /* Slight zoom effect on hover */
    }

    .category-item:hover .category-name {
        background: rgba(0, 0, 0, 0.7);
        /* Darker overlay on hover */
    }

    .category .shop-button {
        margin-top: 3%;
        display: inline-block;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        color: #fff;
        background: #333;
        text-decoration: none;
        border-radius: 25px;
        transition: background 0.3s ease;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    /* Responsive Design for Mobile Devices */
    @media screen and (max-width: 768px) {
        .cat-center {
            gap: 15px;
            /* Reduce spacing on smaller screens */
        }

        .section.category {
            height: max-content;
        }

        .section.category h2 {
            margin-top: 2rem;
        }

        .category-item {
            width: 100%;
            max-width: 100%;
            height: 350px;
            margin-top: 5%;
        }

        .category-item img {
            display: block;
            object-fit: cover;
        }

        .category-name {
            font-size: 1rem;
            /* Adjust font size for mobile */
        }

        .category .shop-button {
            margin-top: 7%;
        }
    }
</style>

</html>