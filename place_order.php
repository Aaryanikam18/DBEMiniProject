<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="search_books.php">Catalog</a>
    <a href="place_order.php">Order</a>
    <a href="add_book.php">Admin (Add Book)</a>
</nav>

<div class="container">
    <h2>Place Order</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $user_id = $_POST['user_id'];
      $book_id = $_POST['book_id'];
      $qty = $_POST['quantity'];
      $date = date('Y-m-d');

      $price_sql = "SELECT price, quantity FROM books WHERE id = '$book_id'";
      $result = $conn->query($price_sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $current_stock = $row['quantity'];

        if ($current_stock >= $qty) {
            $total = $price * $qty;

            $order_sql = "INSERT INTO orders (user_id, book_id, order_date, quantity, total_amount) 
                          VALUES ('$user_id', '$book_id', '$date', '$qty', '$total')";

            if ($conn->query($order_sql) === TRUE) {
                $new_stock = $current_stock - $qty;
                $conn->query("UPDATE books SET quantity = '$new_stock' WHERE id = '$book_id'");
                echo "<div class='msg success'>Order placed successfully! Total: $" . $total . "</div>";
            } else {
                echo "<div class='msg error'>Error placing order: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='msg error'>Error: Not enough stock available.</div>";
        }
      } else {
        echo "<div class='msg error'>Error: Book ID not found.</div>";
      }
    }
    ?>

    <form method="post">
      <label>User ID:</label>
      <input type="number" name="user_id" required placeholder="Enter User ID (e.g. 1)">
      
      <label>Book ID:</label>
      <input type="number" name="book_id" required placeholder="Enter Book ID from Catalog">
      
      <label>Quantity:</label>
      <input type="number" name="quantity" value="1" required>
      
      <input type="submit" value="Buy Book">
    </form>
</div>

</body>
</html>
