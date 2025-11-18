<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Catalog</title>
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
    <h2>Book Catalog</h2>

    <?php
    $search = "";
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%'";
    } else {
        $sql = "SELECT * FROM books";
    }
    $result = $conn->query($sql);
    ?>

    <form method="post">
        <input type="text" name="search" placeholder="Search by Title or Author..." value="<?php echo $search; ?>">
        <input type="submit" value="Search">
    </form>

    <table>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>Stock</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id"] . "</td>";
          echo "<td>" . $row["title"] . "</td>";
          echo "<td>" . $row["author"] . "</td>";
          echo "<td>$" . $row["price"] . "</td>";
          echo "<td>" . $row["quantity"] . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No books found</td></tr>";
      }
      ?>
    </table>
</div>

</body>
</html>
