<?php
    // Link to db
    $database = connectToDB();

    // Chooses table
    $sql = "SELECT * FROM books";
    $sql2 = "SELECT * FROM bookmarks";

    // Prepare statement
    $query = $database->prepare($sql); 
    $query2 = $database->prepare($sql2);

    // Execute
    $query->execute();
    $query2->execute();

    // Fetch data
    $books = $query->fetchAll();
    $bookmarks = $query2->fetchAll();

    require 'parts/header.php';
?>      

<?php
function isBookBookmarked($bookId, $bookmarks) {
    foreach ($bookmarks as $bookmark) {
        if ($bookmark['book_id'] == $bookId) {
            return true;
        }
    }
    return false;
}
?>

<div class="container mt-4">
    <!-- Admin Book Link -->
    <div class="text-start mb-3">
        <a href="/manage-users" class="btn btn-sm">
            <i class="bi bi-person-fill"></i> Manage Users
        </a>
        <a href="/adminbook" class="btn btn-sm">
            <i class="bi bi-plus-circle"></i> Add Book
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach($books as $index => $book) : ?>
            <div class="col">
                <!-- Item Card -->
                <div class="card h-100">
                    <img src="<?= $book['image_url']; ?>" class="card-img-top h-50" alt="" />

                    <form method="POST" action="/auth/submit" class="mt-2">
                        <input type="hidden" name="book_id" value="<?= $book['id']; ?>">
                        <input type="hidden" name="is_wishlist" value="1">
                        <input type="hidden" name="image_url" value="<?= $book['image_url']; ?>">

                        <button type="submit" class="btn btn-link p-0 m-0" style="z-index: 99;">
                            <?php if (isBookBookmarked($book['id'], $bookmarks)) : ?>
                                <!-- If the book is already bookmarked, show filled bookmark icon -->
                                <i class="bi bi-bookmark-fill" style="font-size: 1.5rem;"></i>
                            <?php else : ?>
                                <!-- If not bookmarked, show empty bookmark icon -->
                                <i class="bi bi-bookmark" style="font-size: 1.5rem;"></i>
                            <?php endif; ?>
                        </button>
                    </form>

                    <div class="text-center mt-2">
                        <a href="/desc?id=<?= $book['id']; ?>" class="btn btn-link btn-sm">Read More</a>
                    </div>
                </div><!-- end of card -->
            </div><!-- end of col -->
        <?php endforeach; ?>
    </div><!-- end of row -->

    <div class="mt-4 d-flex justify-content-center gap-3">
        <?php if (isset($_SESSION['user'])) : ?>
            <a href="/logout" class="btn btn-link btn-sm">Logout</a>
        <?php else : ?>
            <!-- show login and signup link if user is not logged in -->
            <a href="/login" class="btn btn-link btn-sm">Login</a>
            <a href="/signup" class="btn btn-link btn-sm">Sign Up</a>
        <?php endif; ?>
    </div>
</div><!-- end of container -->

<?php require 'parts/footer.php'; ?>
