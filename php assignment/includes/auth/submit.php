<?php
// Start the session
// session_start();

// Check if user is logged in
checkIfuserIsNotLoggedIn();

// Connect to the database
$database = connectToDB();

// Get user_id from session
$user_id = $_SESSION['user']['id'] ?? null;

// Get POST data
$book_id = $_POST['book_id'] ?? null;
$is_wishlist = $_POST['is_wishlist'] ?? 1;
$image_url = $_POST['image_url'] ?? "";

// Validate user_id and book_id
if (!$user_id || !$book_id) {
    $_SESSION['error'] = "Invalid user or book ID.";
    header("Location: /home");
    exit;
}

try {
    // Check if the bookmark already exists using placeholders to avoid SQL injection
    $checkSql = "SELECT * FROM bookmarks WHERE user_id = :user_id AND book_id = :book_id";
    $checkQuery = $database->prepare($checkSql);
    $checkQuery->execute([':user_id' => $user_id, ':book_id' => $book_id]);
    $existingBookmark = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($existingBookmark) {
        // If the bookmark already exists, provide feedback
        $_SESSION['success'] = "This book is already bookmarked.";
    } else {
        // Insert new bookmark using placeholders to avoid SQL injection
        $sql = "INSERT INTO bookmarks (user_id, book_id, is_wishlist, image_url) VALUES (:user_id, :book_id, :is_wishlist, :image_url)";
        $query = $database->prepare($sql);
        $query->execute([
            ':user_id' => $user_id,
            ':book_id' => $book_id,
            ':is_wishlist' => $is_wishlist,
            ':image_url' => $image_url,
        ]);

        $_SESSION['success'] = "Bookmark added successfully.";
    }
} catch (PDOException $e) {
    // Display the error for debugging purposes (remove in production)
    echo $e->getMessage();
    exit;
    // Set the error message in the session
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}

// Redirect back to the previous page
header("Location: /home");
exit;
?>
