<?php

// Check if the user is admin or not
checkIfIsNotAdmin();

// Add manage user selection link

// 1. Connect to the database
$database = connectToDB();

try {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $image = trim($_POST['img'] ?? '');
        $description = trim($_POST['descr'] ?? '');

        // Validate form data
        if (empty($title) || empty($author) || empty($description)) {
            echo "<p>All fields except image URL are required.</p>";
        } else {
            // Insert the new book into the database
            $sql = "INSERT INTO books (title, author, image_url, description) VALUES (:title, :author, :image, :description)";
            $query = $database->prepare($sql);
            $success = $query->execute([
                ':title' => $title,
                ':author' => $author,
                ':image' => $image,
                ':description' => $description
            ]);

            if ($success) {
                echo "<p>Book added successfully.</p>";
            } else {
                echo "<p>Failed to add book. Please try again.</p>";
            }
        }
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

require "parts/header_a.php";
?>

<div style="text-align: center; margin-bottom: 20px;"><a href="/admin/manage-users" style="padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Manage Users</a></div>
<form method="POST" action="" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9;">
    <h2 style="text-align: center;">Add New Book</h2>
    
    <div style="margin-bottom: 15px;">
        <label for="title" style="display: block; font-weight: bold;">Title:</label>
        <input type="text" id="title" name="title" value="" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="author" style="display: block; font-weight: bold;">Author:</label>
        <input type="text" id="author" name="author" value="" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="image" style="display: block; font-weight: bold;">Image URL:</label>
        <input type="text" id="image" name="img" value="" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; font-weight: bold;">Description:</label>
        <textarea id="description" name="descr" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; height: 150px;"></textarea>
    </div>
    
    <div style="text-align: center;">
        <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Add Book</button>
    </div>
</form>

