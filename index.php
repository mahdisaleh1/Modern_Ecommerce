<?php
include './config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="./images/icon.png" type="image/x-icon">
    <title>Deems Crochet</title>
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
            <a href="index.php">Deems</a>
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

    <!--HERO SECTION-->
    <section class="hero">
        <div class="hero-text">
            <h1>A NEW ERA OF CROCHET</h1>
            <p>One of a kind Bags Crafted Just For You</p>
            <a href="./shop/shoplist.php" class="shop-button">Shop Now</a>
        </div>
    </section>

    <!-- CATEGORY SECTION -->
    <form action="index.php" method="post">
        <section class="section category">
            <h2>Some Categories</h2>
            <div class="cat-center"><!--
                <div class="category-item">
                    <img src="./images/heroimage.jpg" alt="Category 1">
                    <div class="category-name">Category 1</div>
                </div>
                
                <div class="category-item">
                    <img src="./images/heroimage.jpg" alt="Category 2">
                    <div class="category-name">Category 2</div>
                </div>
                
                <div class="category-item">
                    <img src="./images/heroimage.jpg" alt="Category 3">
                    <div class="category-name">Category 3</div>
                </div>-->
                <?php
                $result = $con->query("SELECT * FROM category WHERE id<4");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='category-item'>";
                        //echo "<h2>" . $row['id'] . "</h2>";
                        echo "<img src='uploads/" . $row["image"] . "' alt='" . $row["name"] . "'>";
                        echo "<div class='category-name'>";
                        echo $row['name'];
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<tr><td colspan='5'> No Products Found </td></tr>";
                }

                ?>
            </div>
            <div class="buttons">
                <a href="./shop/categorylist.php" class="shop-button">Check Now</a>
            </div>
        </section>
    </form>

    <!-- SOME PRODUCTS SECTION -->
    <form method="" action="">
        <section class="products">
            <div class="title">
                <h1>Best Seller</h1>
                <p>All the latest picked from our online store</p>
            </div>

            <div class="product-center">
                <!--  <div class="product-item">
                    <div class="overlay">
                        <a><img src="./images/heroimage.jpg" alt="product1"></a>
                    </div>
                    <div class="product-info">
                        <p>Category</p>
                        <a>Product Name 1</a>
                        <h4>200$</h4>
                    </div>
                </div>
                <div class="product-item">
                    <div class="overlay">
                        <a><img src="./images/heroimage.jpg" alt="product1"></a>
                    </div>
                    <div class="product-info">
                        <p>Category 2</p>
                        <a>Product Name 2</a>
                        <h4>300$</h4>
                    </div>
                </div>
                <div class="product-item">
                    <div class="overlay">
                        <a><img src="./images/heroimage.jpg" alt="product1"></a>
                    </div>
                    <div class="product-info">
                        <p>Category 3</p>
                        <a>Product Name 3</a>
                        <h4>400$</h4>
                    </div>
                </div>-->
                <?php
                $result = $con->query("SELECT * FROM products LIMIT 3");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='product-item'>";
                        echo "<div class='overlay'>";
                        echo "<a href='./shop/shoplist.php'><img src='./uploads/" . $row["image"] . "' alt='" . $row["name"] . "'></a>";
                        echo "</div>";
                        echo "<div class='product-info'>";
                        //echo "<p>" . $row['category'] ."</p>";
                        echo "<a href='#'>" . $row['name'] . "</a>";
                        echo "<h4>$" . $row['price'] . "</h4>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
            </div>

            <div class="buttons">
                <a href="./shop/shoplist.php" class="shop-button">Shop Now</a>
            </div>
        </section>
    </form>


    <!-- CUSTOMIZE SECTION -->
    <section class="customize">
        <div class="custorder">
            <div class="customizetext">
                <h4>Customize Yours Now!</h4>
                <p>Explore our unique, handcrafted items with customizable options to fit your vision.
                    If you don't find exactly what you're looking for, share your ideas, and we'll help turn them into reality</p>
            </div>
            <div class="customizebtn">
                <a href="./shop/customize.php" class="contact-button">Contact Us</a>
            </div>
            <div class="customizeimage">
                <img src="./images/heroimage.jpg" alt="customize">
            </div>
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
    <script src="./js/script.js"></script>
</body>
<script>
    document.getElementById('search-button').addEventListener('click', () => {
        document.getElementById('search-overlay').style.display = 'block';
    });

    document.getElementById('close-search').addEventListener('click', () => {
        document.getElementById('search-overlay').style.display = 'none';
    });

    document.getElementById('search-input').addEventListener("keyup", function() {
        const query = this.value;
        if (query === "") {
            document.getElementById("product-list").innerHTML = "";
            return; // Stop the fetch request
        }
        fetch("search.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `search=${encodeURIComponent(query)}`,
            })
            .then((response) => response.text())
            .then((data) => {
                // Update the product container with the search results
                document.getElementById("product-list").innerHTML = data;
            })
            .catch((error) => console.error("Error:", error));
    });
    /*document.getElementById('search-input').addEventListener('input', function() {
        const query = this.value;
        if (query.length > 2) {
            fetch(`search.php?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const productList = document.getElementById('product-list');
                    productList.innerHTML = '';

                    data.products.forEach(product => {
                        const item = document.createElement('div');
                        item.classList.add('product-item');
                        item.innerHTML = `
                        <img src="${product.image}" alt="${product.name}">
                        <p>${product.name}</p>
                    `;
                        productList.appendChild(item);
                    });
                });
        }
    });
    document.getElementById('search-input').addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length > 1) {
        fetch(`search.php?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const productList = document.getElementById('product-list');

                // Generate HTML content directly with template literals
                productList.innerHTML = data.products && data.products.length > 0
                    ? data.products.map(product => `
                        <div class="product-item">
                            <img src="${product.image}" alt="${product.name}">
                            <p>${product.name}</p>
                        </div>
                    `).join('')
                    : `<p>No results found</p>`;
            })
            .catch(error => console.error('Error fetching data:', error));
    } else {
        document.getElementById('product-list').innerHTML = ''; // Clear results for short inputs
    }
});*/
</script>
<style>
    .product-item .overlay img {
        width: 100%;
        height: 45vh;
        display: block;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .overlayy {
        justify-items: center;
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
    }

    #search-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: flex-start;
        
        z-index: 9999;
        /* Ensures it's above everything */
    }

    /* Search Container */
    .search-container {
        display: flex;
        align-items: center;
        background: #fff;
        background-color: #fff;
        border-radius: 30px;
        padding: 10px 20px;
        width: 50%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .searchinp {
        flex: 1;
        border: none;
        outline: none;
        font-size: 18px;
        padding: 10px;
        border-radius: 20px;
    }

    .closesearchbar {
        background: transparent;
        color: #fff;
        border: 2;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        margin-left: 15px;
        position: absolute;
        right: -40px;
        top: 30%;
    }

    /* Search Results */
    #search-results {
        margin-top: 20px;
        width: 50%;
        max-height: 60vh;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        overflow-y: auto;
        /* Scrollable if results exceed max height */
    }

    .products {
        padding: 15px;
    }
    
    #product-list .product-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #eee;
        width: 100%;
        max-width: 90%;
        margin-left: 5%;
        margin-top: 1%;
    }

    #product-list .product-item img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        margin-right: 15px;
    }

    #product-list .product-item p{
        font-size: 16px;
        flex: 1;
        color: #333;
        margin: 0;
        text-decoration: none;
    }

    /* Hover effect */
    #product-list .product-item:hover {
        background: #f5f5f5;
        cursor: pointer;
    }

    /* Show the overlay */
    #search-overlay.active {
        display: flex;
    }



    /*.product-item {
        margin-top: 10%;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }*/

    @media screen and (max-width: 768px) {
        .product-item .overlay img {
            height: 35vh;
        }
    }
</style>

</html>