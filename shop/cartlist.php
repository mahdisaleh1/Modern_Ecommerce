<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_quantity"])) {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    if ($quantity > 0) {
        $_SESSION["cart"][$product_id]["quantity"] = $quantity;
    } else {
        unset($_SESSION["cart"][$product_id]);
    }
}

// Handle product removal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_product"])) {
    $product_id = $_POST["product_id"];
    unset($_SESSION["cart"][$product_id]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cartlist.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
    <title>Your Shopping Cart - Deems</title>
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


    <!-- Cart SECTION -->

    <section class="section cart">
        <div class="cartheader">
            <h2>Your Cart</h2>
            <a href="./shoplist.php">
                <p>Continue Shopping</p>
            </a>
        </div>
        <form action="" method="post">
            <?php
            if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
                echo "<table class='carttable'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Product</th>";
                echo "<th class='quantitysect'>Quantity</th>";
                echo "<th>Total</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                $total = 0;
                $count = 0;

                foreach ($_SESSION["cart"] as $product_id => $product) {
                    $variant_query = "SELECT * FROM productvariants WHERE product_id = ? AND variant_id = '2'";
                    $stmt = $con->prepare($variant_query);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $variants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    if (count($variants) > 0) {
                        $count++;
                        $subtotal = $product["variant_price"] * $product["quantity"];
                        $total += $subtotal;
                        echo "<tr>";
                        echo "<td class='productinfocart'><a  href='./productdetails.php?product_id=" . $product['id'] . "' name='product_detail'><img src='../uploads/" . $product["image"] . "' alt='" . $product["name"] . "'></a>";
                        echo "<div class='product-details'><a  href='./productdetails.php?product_id=" . $product['id'] . "' name='product_detail'>" . $product["name"] . "</a>";
                        echo "<p>Size: " . htmlspecialchars($product['variant_value']) . "</p>";
                        echo "<p>Price: $" . number_format($product['variant_price'], 2) . "</p>";
                        //echo "<p>$" . number_format($product["price"], 2) ."</p>" ;
                        echo "</div><td>";
                        echo "<div class='quantity-buttons'>";
                        echo "<form method='post' action='' style='display: inline;'>";
                        echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                        echo "<input type='hidden' name='quantity' value='" . ($product["quantity"] - 1) . "'>";
                        echo "<button type='submit' name='update_quantity'>-</button>";
                        echo "</form>";
                        echo $product["quantity"];
                        echo "<form method='post' action='' style='display: inline;'>";
                        echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                        echo "<input type='hidden' name='quantity' value='" . ($product["quantity"] + 1) . "'>";
                        echo "<button type='submit' name='update_quantity'>+</button>";
                        echo "</form>";
                        echo "<form method='post' action='' style='display: inline;'>";
                        echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                        echo "<button type='submit' name='remove_product' class='remove-button'><i class='bx bx-trash'></i></button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td>$" . number_format($subtotal, 2) . "</td>";
                        echo "</tr>";
                    }
                    else {
                        $count++;
                        $subtotal = $product["price"] * $product["quantity"];
                        $total += $subtotal;
                        echo "<tr>";
                        echo "<td class='productinfocart'><a  href='./productdetails.php?product_id=" . $product['id'] . "' name='product_detail'><img src='../uploads/" . $product["image"] . "' alt='" . $product["name"] . "'></a>";
                        echo "<div class='product-details'><a  href='./productdetails.php?product_id=" . $product['id'] . "' name='product_detail'>" . $product["name"] . "</a>";
                        echo "<p>Price: $" . number_format($product['price'], 2) . "</p>";
                        //echo "<p>$" . number_format($product["price"], 2) ."</p>" ;
                        echo "</div><td>";
                        echo "<div class='quantity-buttons'>";
                        echo "<form method='post' action='' style='display: inline;'>";
                        echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                        echo "<input type='hidden' name='quantity' value='" . ($product["quantity"] - 1) . "'>";
                        echo "<button type='submit' name='update_quantity'>-</button>";
                        echo "</form>";
                        echo $product["quantity"];
                        echo "<form method='post' action='' style='display: inline;'>";
                        echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                        echo "<input type='hidden' name='quantity' value='" . ($product["quantity"] + 1) . "'>";
                        echo "<button type='submit' name='update_quantity'>+</button>";
                        echo "</form>";
                        echo "<form method='post' action='' style='display: inline;'>";
                        echo "<input type='hidden' name='product_id' value='" . $product_id . "'>";
                        echo "<button type='submit' name='remove_product' class='remove-button'><i class='bx bx-trash'></i></button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td>$" . number_format($subtotal, 2) . "</td>";
                        echo "</tr>";
                    }
                } ?></tbody>
                </table>
                <div class="totaldiv">
                    <p class="totalparag">Estimated Total: $<?php echo number_format($total, 2); ?></p>
                    <p class="shipping">Shipping is calculated at checkout.</p>
                </div>
                <div class="buttons">
                    <a href="./checkoutcart.php"><button type="button" class="checkoutbtn">Check out</button></a>
                </div>

            <?php
            } else {
                //echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
                echo "<div class='noproductsdiv'>";
                echo "<h2>Your cart is empty!</h2>";
                echo "<div class='noproductsbtns'>";
                echo "<a href='./shoplist.php'>Shop now!</a>";
                echo "</div>";
                echo "<div class='noproductslogindiv'>";
                echo "<h4>Already have account? <a href='../user/login.php'>Login Here</a>!</h4>";

                echo "</div>";
                echo "</div>";
            }
            ?>
        </form>

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
        fetch("./search.php", {
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
</script>
<style>

</style>

</html>