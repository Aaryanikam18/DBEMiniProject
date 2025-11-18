<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
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
    <h2>Add New Book</h2>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $title = $_POST['title'];
      $author = $_POST['author'];
      $isbn = $_POST['isbn'];
      $price = $_POST['price'];
      $quantity = $_POST['quantity'];

      $sql = "INSERT INTO books (title, author, isbn, price, quantity) 
              VALUES ('$title', '$author', '$isbn', '$price', '$quantity')";

      if ($conn->query($sql) === TRUE) {
        echo "<div class='msg success'>New book added successfully!</div>";
      } else {
        echo "<div class='msg error'>Error: " . $conn->error . "</div>";
      }
    }
    ?>

    <form method="post">
      <label>Title:</label>
      <input type="text" name="title" required>
      
      <label>Author:</label>
      <input type="text" name="author" required>
      
      <label>ISBN:</label>
      <input type="text" name="isbn" required>
      
      <label>Price:</label>
      <input type="number" step="0.01" name="price" required>
      
      <label>Quantity:</label>
      <input type="number" name="quantity" required>
      
      <input type="submit" value="Add Book">
    </form>
</div>

</body>
</html>
