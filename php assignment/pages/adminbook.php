<?php

  // check if the user is admin or not
  checkIfIsNotAdmin();

   // check if whoever that viewing this page is logged in.
  // if not logged in, you want to redirect back to login page
  checkIfuserIsNotLoggedIn();

  checkIfIsNotAdminOrEditor();

// 1. Connect to the database
$database = connectToDB();

try {
    // Display all books
    $sql = "SELECT id, title, author, image_url FROM books";
    $query = $database->prepare($sql);
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

require "parts/header_a.php";
?>



<div style="max-width: 800px; margin: 0 auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Title</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Author</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Image</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $b): ?>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;"> <?php echo($b['title']); ?> </td>
                    <td style="border: 1px solid #ddd; padding: 8px;"> <?php echo($b['author']); ?> </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        <img src="<?php echo($b['image_url']); ?>" alt="<?php echo($b['title']); ?>" style="width: 50px; height: auto;">
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        <a href="/adminedit" style="margin-right: 10px; text-decoration: none; color: #007BFF;">Edit</a>
                        <a href="/adminadd" style="margin-right: 10px; text-decoration: none; color: #007BFF;">Add</a>
                        <a href="/admindelete" style="text-decoration: none; color: #FF6347;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>