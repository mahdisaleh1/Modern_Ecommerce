<?php
include '../config.php';
session_start();
$product_id = $_GET['product_id'];
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
if (isset($_POST['spanValue'])) {
    $spanValue = $_POST['price'];
    // Now you can use $spanValue in PHP
    echo "Received value: " . $spanValue;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["add_to_cart"])) {

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        // Get product details from database
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $qty = (int)($_POST['qtyadded']);
            $variant_id = $_POST['size']; // Get selected variant ID from the dropdown
            $variant_price = $_POST['variant_price'];
            if ($qty <= 0) {
                echo '<script>alert("Enter the quantity you want!" );</script>';
            } else {
                // Add product to cart
                $variant_query = "SELECT * FROM productvariants WHERE product_variant_id = ?";
                $stmt = $con->prepare($variant_query);
                $stmt->bind_param("i", $variant_id);
                $stmt->execute();
                $variant_result = $stmt->get_result();
                $variant = $variant_result->fetch_assoc();
                $product['variant_id'] = $variant['product_variant_id'];
                $product['variant_value'] = $variant['value'];
                $product['variant_price'] = $variant_price;

                $product['quantity'] = $qty;
                $_SESSION["cart"][$product_id] = $product;
                echo '<script>alert("Product has been added successfuly!" );</script>';
                header("location:./shoplist.php");
            }
        } else {
            echo '<script>alert("An error has been occured!" );</script>';
            header("location:../error/error.php");
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
    <link rel="stylesheet" href="../css/shop.css">
    <link rel="stylesheet" href="../css/productdetails.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Product Details - Deems</title>
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
            <a href="#"><i class="bx bx-search"></i></a>
            <a href="../user/login.php"><i class="bx bx-user"></i></a>
            <a href="./cartlist.php"><i class="bx bx-cart"></i></a>
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
    <!--<div class="container">
        <form method="" action="">
            <section class="products">
                <div class="title">
                    <h1>Product Details</h1>
                </div>
                <div class="product-center">
                    <div class="product-item">
                        <div class="overlay">
                            <a><img src="../images/baricontwo.jpg" alt="product1"></a>
                        </div>
                        <div class="product-info">
                            <a>Brownie</a>
                            <h4>200$</h4>
                        </div>
                        
                        <form method='post' action=''>
                            <input type='hidden' name='product_id' value='" . $row["id"] . "'>
                            <div class='buttons'>
                                <button type='submit' name='add_to_cart' onclick='productalert()'><i class='bx bx-cart'></i></button>
                                <button type='submit' name='add_to_favorites' class='favorites' onclick='productalert()'><i class='bx bx-heart'></i></button>
                            </div>
                        </form>
                    </div>


                </div>
            </section>
        </form>
    </div>-->

    <!-- Product-Details_Section-->

    <section class="section product-details">
        <div class="details_container">
            <div class="left image-container">
                <div class="main">
                    <?php
                    echo "<img src='../uploads/" . $product["image"] . "' alt='" . $product["name"] . "'>";
                    ?>
                </div>
            </div>
            <div class="right">
                <div class="right">
                    <?php echo "<input type='hidden' name='product_id' value='" . $product["id"] . "'>"; ?>
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>

                    <!--Category:
                    <h4><?php echo htmlspecialchars($product['category']); ?></h4><br>-->
                    <div class="price">
                        $<span id="price"><?php echo number_format($product['price'], 2); ?></span>
                        <p>(Shipping calculated at checkout)</p>
                    </div>


                    <?php
                    // Fetch size variants from productvariants table
                    $variant_query = "SELECT * FROM productvariants WHERE product_id = ? AND variant_id = '2'";
                    $stmt = $con->prepare($variant_query);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $variants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                    $stmt->close();
                    $con->close();
                    if (count($variants) > 0):
                    ?>
                        <form class="form" method="post" action="productdetails.php?product_id=<?php echo $product_id; ?>" onsubmit="return checkSelection()">
                            <p>Choose the Size:</p>
                            <select id="size" class="selectsize" name="size" onchange="updatePrice()">
                                <option value="" class="circle-option">Choose here</option>
                                <?php

                                foreach ($variants as $variant): ?>
                                    <option class="circle-option" data-price="<?php echo $variant['price']; ?>" value="<?php echo $variant['product_variant_id']; ?>" data-variant-id="<?php echo $variant['product_variant_id']; ?>">
                                        <?php echo $variant['value'];
                                        ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!--<input type="color" value="white"> -->

                            <input type="hidden" id="variant_price" name="variant_price" value="">
                            <div>
                                Quantity:<br>
                                <input type="text" placeholder="0" class="qtyadded" name="qtyadded" />
                                <button type="submit" class="addCart" name="add_to_cart" onclick='productalert()'>Add To Cart</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <form class="form" method="post" action="productdetails.php?product_id=<?php echo $product_id; ?>" onsubmit="return checkSelection()">
                            <input type="hidden" id="variant_price" name="variant_price" value="">
                            <div>
                                Quantity:<br>
                                <input type="text" placeholder="0" class="qtyadded" name="qtyadded" />
                                <button type="submit" class="addCart" name="add_to_cart" onclick='productalert()'>Add To Cart</button>
                            </div>
                        </form>
                    <?php endif; ?>
                    <br>
                    <h3>Product Description:</h3>
                    <p>
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <span id="variant_id_choosen" class="variantidspan" name="variant_id"><?php echo $variant['product_variant_id']; ?></span>



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
    <script>
        function checkSelection() {
            var sizeSelect = document.getElementById('size');
            var selectedSize = sizeSelect.value;

            if (selectedSize === "") {
                alert("Please choose a size before adding to cart.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission if size is selected
        }

        function updatePrice() {
            // Get the selected size option
            var sizeSelect = document.getElementById('size');
            var selectedOption = sizeSelect.options[sizeSelect.selectedIndex];

            // Get the price from the data-price attribute of the selected option
            var newPrice = selectedOption.getAttribute('data-price');

            // Update the price on the page
            document.getElementById('price').innerText = parseFloat(newPrice).toFixed(2);

            // Update the hidden input for variant price
            document.getElementById('variant_price').value = newPrice;
        }
        document.getElementById('size').addEventListener('change', function() {

            const selectedOption = this.options[this.selectedIndex];
            const selectedPrice = selectedOption ? selectedOption.getAttribute('data-price') : "<?php echo number_format($product['price'], 2); ?>";
            //const selectedPrice = this.value;
            //const priceElement = document.getElementById('price');
            //priceElement.textContent = selectedPrice ? selectedPrice : "<?php echo number_format($product['price'], 2); ?>";

            const selectedVariant = document.getElementById('variant_id_choosen');
            selectedVariant.textContent = selectedOption ? selectedOption.getAttribute('data-variant-id') : "<?php echo number_format($variant['product_variant_id'], 2); ?>";

            var spanValue = document.getElementById("price").textContent; // Get value from the span
            // Create an AJAX request to send the data to PHP
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "productdetails.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // Send the span value to PHP
            xhr.send("spanValue=" + encodeURIComponent(spanValue));
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText); // Handle the response from PHP if needed
                }
            };
        });
    </script>
</body>

</html>