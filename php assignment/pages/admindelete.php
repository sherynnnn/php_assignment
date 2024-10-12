<?php




// 1. Connect to the database
$database = connectToDB();

try {
    // Display all books to select for deletion
    $sql = "SELECT id, title FROM books";
    $query = $database->prepare($sql);
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    echo '<div style="text-align: center; margin-bottom: 20px;">
            <form method="POST" action="" style="display: inline-block;">
                <label for="book_delete" style="font-weight: bold;">Select a Book to Delete:</label>
                <select name="delete_id" id="book_delete" style="padding: 5px; margin-right: 10px;">
                    <option value="">-- Select a Book --</option>';
    foreach ($books as $b) {
        echo '<option value="' . ($b['id']) . '">' . ($b['title']) . '</option>';
    }
    echo '</select>
                <button type="submit" name="delete" style="padding: 5px 10px; background-color: #FF6347; color: white; border: none; border-radius: 5px; cursor: pointer;">Delete</button>
            </form>
          </div>';

    // Handle form submission for deletion
    if (isset($_POST['delete'])) {
        $delete_id = intval($_POST['delete_id'] ?? 0);
        if ($delete_id > 0) {
            $sql = "DELETE FROM books WHERE id = :id";
            $query = $database->prepare($sql);
            $success = $query->execute([':id' => $delete_id]);

            if ($success) {
                echo "<p>Book deleted successfully.</p>";
            } else {
                echo "<p>Failed to delete book. Please try again.</p>";
            }
        } else {
            echo "<p>Please select a valid book to delete.</p>";
        }
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

require "parts/header_a.php";
?>