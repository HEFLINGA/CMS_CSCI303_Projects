<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/27/2023
 * Time: 10:24 AM
*/

$pageName = "View Review";
require_once "header.php";

// Check to see if $_GET['q'] has been set
if (!isset($_GET['q']) || !is_numeric($_GET['q'])) {
    ?>
    <p class="error">There was an error viewing this content.</p>
    <?php
} else {

    // Query the data
    $sql = "SELECT * FROM books LEFT JOIN users 
            ON users.ID = books.userID
            WHERE books.ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $_GET['q']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display the stuff to the screen for the user to view
    if (empty($row['username'])) {
        $row['username'] = "[DELETED USER]";
    }
    ?>
    <div class="review">
        <div class="container">
            <div class="item left">
                <img src="<?php echo "/amhefling/csci303sp23/uploads/" . $row['imagepath']; ?>" alt="Book Cover Image" width="300" height="360">
            </div>
            <div class="item middle">
                <table class="view_content">
                    <tr><th>Title: </th><td class="title"><h4><?php echo $row['title']; ?></h4></td></tr>
                    <tr><th>Creator: </th><td><?php echo $row['username']; ?></td></tr>
                    <tr><th>Date: </th><td><?php echo date("F d, y", strtotime($row['added'])); ?></td></tr>
                </table>
            </div>
            <div class="item right">
                <h4>Review:</h4>
                <p><?php echo $row['comments']; ?></p>
            </div>
        </div>
    </div>
    <?php

} // End of ifelse statement


require_once "footer.php";