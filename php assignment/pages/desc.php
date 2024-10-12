<?php

// 1. get the id from the URL
$book_id = $_GET['id'] ?? 0;
// 2. connect to Database
$database = connectToDB();
// 3. load the Book data
$sql = "SELECT books.id, books.title, books.author, books.description, books.image_url 
        FROM books 
        WHERE books.id = :id";  
$query = $database->prepare($sql);
$query->execute([
  'id' => $book_id
]);
$book = $query->fetch();

// Fetch comments for the book
$sql = "SELECT comments.*, users.name AS commenter_name 
        FROM comments 
        JOIN users ON comments.user_id = users.id 
        WHERE comments.book_id = :book_id";
$query = $database->prepare($sql);
$query->execute(['book_id' => $book_id]);
$comments = $query->fetchAll();

require "parts/header.php"; ?>




<div style="display: flex; justify-content: space-between; max-width: 1200px; margin: 0 auto;">
    <div style="width: 65%; padding-right: 20px;">
        <?php if ($book): ?>
            <h2><?= ($book['title']); ?></h2>
            <p><strong>Author:</strong> <?= ($book['author']); ?></p>
            <div>
                <img src="<?= ($book['image_url']); ?>" alt="" style="max-width: 100%; height: auto;">
            </div>
            <p style="margin-top: 20px;">
                <?= nl2br(($book['description'])); ?>
            </p>
        <?php else: ?>
            <p>Book not found.</p>
        <?php endif; ?>

            
        
        <div class="mt-4">
            <h4>Leave a Comment</h4>
            <form method="POST" action="/user/comment">
                <input type="hidden" name="book_id" value="<?= $book_id; ?>">
                <input type="text" class="form-control mb-3" name="username" placeholder="Your name" required>
                <textarea class="form-control mb-3" name="comment" placeholder="Write your comment..." rows="3" required></textarea>
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>

        <div style="margin-top: 40px;">
    <h3>Comments:</h3>
    <?php if (empty($comments)): ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div style="margin-bottom: 20px;">
                <strong><?= ($comment['commenter_name']); ?>:</strong>
                <p><?= nl2br(($comment['comment'])); ?></p>
                <small>Posted on: <?= ($comment['posted_on']); ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</div>

<?php require "parts/footer.php"; ?>
