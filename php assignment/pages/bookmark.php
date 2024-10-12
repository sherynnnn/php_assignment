<?php


$database = connectToDB();

// Get user_id from session
$user_id = $_SESSION['user']['id'] ?? null;

// Check if user is logged in
if (!$user_id) {
    $_SESSION['error'] = "You need to be logged in to view your bookmarks.";
    header("Location: /login");
    exit;
}

// Fetch all bookmarks for the logged-in user
$sql = "SELECT books.id, books.title, books.author, books.image_url, bookmarks.id AS bookmark_id 
        FROM books 
        INNER JOIN bookmarks ON books.id = bookmarks.book_id 
        WHERE bookmarks.user_id = :user_id";
$query = $database->prepare($sql);
$query->execute(['user_id' => $user_id]);
$bookmarks = $query->fetchAll(PDO::FETCH_ASSOC);

require 'parts/header.php';
?>

<div class="container mt-5">
    <h2>Your Bookmarked Books</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($bookmarks)) : ?>
            <?php foreach ($bookmarks as $bookmark) : ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= ($bookmark['image_url']); ?>" class="card-img-top" alt="Book Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= ($bookmark['title']); ?></h5>
                            <p class="card-text"><?= ($bookmark['author']); ?></p>
                        </div>
                        <form method="POST" action="/auth/delete_bookmark">
                            <input type="hidden" name="bookmark_id" value="<?= $bookmark['bookmark_id']; ?>">
                            <button class="btn btn-danger btn-sm" type="submit">Remove Bookmark</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No bookmarks found.</p>
        <?php endif; ?>
    </div>
</div>

<?php require 'parts/footer.php'; ?>
