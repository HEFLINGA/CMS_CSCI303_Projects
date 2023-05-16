<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/26/2023
 * Time: 10:13 AM
*/

$pageName = "Book Reviews";
require_once "header.php";

?>
<form class="review_search" name="review_search" id="review_search" method="get" action="<?php echo $currentFile; ?>">
    <label for="term">Search for Reviews:</label>
    <input type="search" id="term" name="term" placeholder="Search...">
    <input type="submit" id="search" name="search" value="SEARCH">
</form>
<?php

// Set up the sort feature
if (isset($_GET['q'])){
    switch ($_GET['q']){
        case "td":
            $sort = "title DESC";
            break;
        case "ta":
            $sort = "title";
            break;
        case "ud":
            $sort = "username DESC";
            break;
        case "ua":
            $sort = "username";
            break;
        default:
            $sort = "title";
    } // switch statement
} else {
    $sort = "title";
}

// Query the book data
if(!isset($_GET['search'])) {

    $sql = "SELECT books.ID, books.title, books.userID, users.username
    FROM books JOIN users
    ON books.userID = users.ID
    ORDER BY $sort";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    if (empty($_GET['term'])) {
        echo "<p class='error'>The search field was empty! Please type your search into the search bar.<br>
                Click <a href='bookreviews.php'>HERE</a> to return to all reviews.</p>";
    } else {
        $term = trim($_GET['term']) . "%";

        $sql = "SELECT books.ID, books.title, books.userID, users.username
        FROM books JOIN users
        ON books.userID = users.ID
        WHERE books.title LIKE :term
        ORDER BY books.title";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            echo "<p class='error'>There are no results for " . htmlspecialchars($_GET['term']) . ". Please try another search.<br>
             Click <a href='bookreviews.php'>HERE</a> to return to all reviews.</p>";
        } else {
            echo "<p class='success'>Here are the search results:</p>";
        } // if results 'empty'
    } // if search 'empty'
}
?>
<table class="book_reviews">
    <?php if(!isset($_GET['search'])) { ?>
    <tr><th>Title<a href="<?php echo $currentFile; ?>?q=ta">&#8639;</a><a href="<?php echo $currentFile; ?>?q=td">&#8642;</a></th><th>Reviewer<a href="<?php echo $currentFile; ?>?q=ua">&#8639;</a><a href="<?php echo $currentFile; ?>?q=ud">&#8642;</a></th><th>Options</th></tr>
    <?php
    } else {
        ?>
        <tr><th>Title</th><th>Reviewer</th><th>Options</th></tr>
    <?php
    }
    if(isset($results)){
        foreach($results as $row) {
            ?>
            <tr>
                <td><?php echo $row['title']?></td>
                <td><?php echo $row['username'] ?></td>
                <td>
                    <a href="viewreview.php?q=<?php echo $row['ID']?>">View</a> |
                    <?php if(isset($_SESSION['ID'])) {
                        if ($_SESSION['ID'] == $row['userID'] || $_SESSION['admin'] == 1) {
                            ?>
                            <a href="updatereview.php?q=<?php echo $row['ID']?>">Update</a> |
                            <a href="deletereview.php?q=<?php echo $row['ID']?>">Delete</a>
                            <?php
                        }
                    } ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>
<?php

require_once "footer.php";