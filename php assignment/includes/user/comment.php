<?php
session_start();

// Connect to the database
$database = connectToDB();

// Get form data
$book_id = $_POST["book_id"] ?? 0;
$username = $_POST["username"] ?? '';
$comment = $_POST["comment"] ?? '';
$user_id = $_SESSION["user"]["id"] ?? 0;

// Error checking - make sure all the fields are not empty
if (empty($book_id) || empty($username) || empty($comment)) {
    setError("All the fields are required.", "/desc?id=" . $book_id);
    exit;
}

var_dump($user_id);

// Corrected SQL statement without incorrect backticks
$sql = "INSERT INTO comments (username, posted_on, comment, book_id, user_id) VALUES (:username, NOW(), :comment, :book_id, :user_id)";
$query = $database->prepare($sql);
$query->execute([
    'username' => ($username),
    'comment' => ($comment),
    'book_id' => $book_id,
    'user_id' => $user_id
]);

// Redirect back to the post
header("Location: /desc?id=" . $book_id);
exit;
