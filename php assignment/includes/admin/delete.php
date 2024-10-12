<?php

// 1. Connect to the database
$database = connectToDB();

// 2. Get the book ID from the query parameter
$book_id = $_GET['id'] ?? 0;
$book_id = intval($book_id);

// 3. Delete the book
if ($book_id > 0) {
    // 3.1 - Prepare SQL query to delete the book based on its ID
    $sql = "DELETE FROM books WHERE id = :id";

    // 3.2 - Prepare the SQL query using the database connection
    $query = $database->prepare($sql);

    // 3.3 - Execute the query, passing the book ID as a parameter
    $query->execute([
        'id' => $book_id
    ]);

    // 4. Redirect to the manage books page
    header("Location: /admin/manage-books");
    exit;
}

require "parts/header_a.php";
?>