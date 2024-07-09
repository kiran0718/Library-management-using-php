<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add book
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_year = $_POST['published_year'];
    
    $sql = "INSERT INTO books (title, author, published_year) VALUES ('$title', '$author', '$published_year')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $sql = "DELETE FROM books WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch books
$sql = "SELECT id, title, author, published_year FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Management</title>
</head>
<body>
    <h1>Library Management</h1>
    
    <h2>Add Book</h2>
    <form method="post" action="">
        <label>Title:</label><br>
        <input type="text" name="title" required><br>
        <label>Author:</label><br>
        <input type="text" name="author" required><br>
        <label>Published Year:</label><br>
        <input type="number" name="published_year" required><br><br>
        <button type="submit" name="add">Add Book</button>
    </form>
    
    <h2>Books List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Published Year</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td>" . $row["title"]. "</td>
                        <td>" . $row["author"]. "</td>
                        <td>" . $row["published_year"]. "</td>
                        <td><a href='?delete=" . $row["id"]. "'>Delete</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No books found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
