<?php



// 1. Connect to the database
$database = connectToDB();

try {
    // Display all books to select for editing or deleting
    $sql = "SELECT id, title FROM books";
    $query = $database->prepare($sql);
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

require "parts/header_a.php";
?>



<div style="text-align: center; margin-bottom: 20px;">
    <form method="GET" action="" style="display: inline-block;">
        <label for="book_select" style="font-weight: bold;">Select a Book to Edit:</label>
        <select name="id" id="book_select" style="padding: 5px; margin-right: 10px;">
            <option value="">-- Select a Book --</option>
            <?php foreach ($books as $b): ?>
                <option value="<?= htmlspecialchars($b['id']); ?>" <?= isset($_GET['id']) && $_GET['id'] == $b['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($b['title']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" style="padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Edit</button>
    </form>
</div>

<?php

// Handle the book editing form if a book is selected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && intval($_POST['id']) > 0) {
    // Update the book in the database
    $book_id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['descr']);

    try {
        $sql = "UPDATE books SET title = :title, author = :author, description = :description WHERE id = :id";
        $query = $database->prepare($sql);
        $success = $query->execute([
            ':title' => $title,
            ':author' => $author,
            ':description' => $description,
            ':id' => $book_id
        ]);

        if ($success) {
            echo "<p style='color: green; text-align: center;'>Book updated successfully.</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Failed to update book. Please try again.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red; text-align: center;'>Error: " . $e->getMessage() . "</p>";
    }
}

// Display the edit form if a book is selected via GET
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
    $book_id = intval($_GET['id']);
    try {
        // Get the book details
        $sql = "SELECT id, title, author, image_url, description FROM books WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([':id' => $book_id]);
        $book = $query->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            echo "<p>Book not found. Please check the book ID: $book_id</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
    ?>

    <form method="POST" action="" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
        <h2 style="text-align: center;">Edit Book Details</h2>
        
        <input type="hidden" name="id" value="<?php echo($book['id'] ?? ''); ?>">
        
        <div style="margin-bottom: 15px;">
            <label for="title" style="display: block; font-weight: bold;">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo($book['title'] ?? ''); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="author" style="display: block; font-weight: bold;">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo($book['author'] ?? ''); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="image_url" style="display: block; font-weight: bold;">Image URL:</label>
            <p><?php echo($book['image_url'] ?? ''); ?></p>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="description" style="display: block; font-weight: bold;">Description:</label>
            <textarea id="description" name="descr" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; height: 150px;"><?php echo htmlspecialchars($book['description'] ?? ''); ?></textarea>
        </div>
        
        <div style="text-align: center;">
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Update Book</button>
        </div>
    </form>

    <?php
}

require "parts/footer.php";
?>