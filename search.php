<?php
include './config.php';
/*
if (isset($_GET['q'])) {
    $query = $_GET['q'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%:query%'");
    $stmt->execute(['query' => "%$query%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($result->num_rows>0){
        while ($row = $results->fetch_assoc()){
          echo $row['name'];
        }
    }
   echo json_encode(['products' => $results]);  
}*/

if (isset($_POST['search'])) {
    $search = $con->real_escape_string($_POST['search']);
    $sql = "SELECT * FROM products 
            WHERE name LIKE '%$search%' ";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-item'>";
            echo "<a href='./shop/productdetails.php?product_id=" . $row['id'] . "'><img src='./uploads/" . $row["image"] . "' alt='" . $row["name"] . "'></a>";
            echo "<p>" . $row['name'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='product-item'>";
        echo "<p>No products found!</p>";
        echo "</div>";
    }
}
