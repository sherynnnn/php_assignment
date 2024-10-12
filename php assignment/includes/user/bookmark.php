<?php

// 1. Connect to the database
$database = connectToDB();

// 3. Handle bookmark toggle functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $user_id = $_SESSION['user_id'] ?? 0;
    $id = intval($_POST['id']);

    if ($user_id > 0 && $id > 0) {
        // Check if the bookmark already exists
        $sql = "SELECT * FROM bookmarks WHERE user_id = :user_id AND book_id = :book_id";
        $query = $database->prepare($sql);
        $query->execute(['user_id' => $user_id, 'book_id' => $id]);
        $bookmark = $query->fetch(PDO::FETCH_ASSOC);

        if ($bookmark) {
            // Remove bookmark if it exists
            $sql = "DELETE FROM bookmarks WHERE user_id = :user_id AND book_id = :book_id";
        } else {
            // Add bookmark if it does not exist
            $sql = "INSERT INTO bookmarks (user_id, book_id) VALUES (:user_id, :book_id)";
        }

        $query = $database->prepare($sql);
        $query->execute(['user_id' => $user_id, 'book_id' => $id]);
    }

}

// 4. Get the logged-in user's ID
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id === 0) {
    echo "<p>Please log in to view your bookmarked books.</p>";
    exit;
}

// 5. Fetch all bookmarked books for the user
$sql = "SELECT books.id, books.title, books.author, books.image_url FROM books 
        INNER JOIN bookmarks ON books.id = bookmarks.book_id 
        WHERE bookmarks.user_id = :user_id";
$query = $database->prepare($sql);
$query->execute(['user_id' => $user_id]);
$bookmarks = $query->fetchAll(PDO::FETCH_ASSOC);

header("Location: /bookmark");
exit;