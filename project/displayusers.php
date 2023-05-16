<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 5/2/2023
 * Time: 5:36 PM
*/

$pageName = "All Reviewers";
require_once "header.php";

?>
    <form class="users_search" name="users_search" id="users_search" method="get" action="<?php echo $currentFile; ?>">
        <label for="term">Search for Reviewers:</label>
        <input type="search" id="term" name="term" placeholder="Search...">
        <input type="submit" id="search" name="search" value="SEARCH">
    </form>
<?php

// Set up the sort feature
if (isset($_GET['q'])){
    switch ($_GET['q']){
        case "ed":
            $sort = "email DESC";
            break;
        case "ea":
            $sort = "email";
            break;
        case "ud":
            $sort = "username DESC";
            break;
        case "ua":
            $sort = "username";
            break;
        default:
            $sort = "username";
    } // switch statement
} else {
    $sort = "username";
}

// Query the book data
if(!isset($_GET['search'])) {

    $sql = "SELECT * FROM users
            ORDER BY $sort";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    if (empty($_GET['term'])) {
        echo "<p class='error'>The search field was empty! Please type your search into the search bar.<br>
                Click <a href='displayusers.php'>HERE</a> to return to all reviewers.</p>";
    } else {
        $term = trim($_GET['term']) . "%";

        $sql = "SELECT * FROM users
        WHERE users.username LIKE :term
        ORDER BY users.username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            echo "<p class='error'>There are no results for " . htmlspecialchars($_GET['term']) . ". Please try another search.<br>
             Click <a href='displayusers.php'>HERE</a> to return to all reviewers.</p>";
        } else {
            echo "<p class='success'>Here are the search results:</p>";
        } // if results 'empty'
    } // if search 'empty'
}
?>
    <table>
        <?php if(!isset($_GET['search'])) { ?>
            <tr><th>Username<a href="<?php echo $currentFile; ?>?q=ua">&#8639;</a><a href="<?php echo $currentFile; ?>?q=ud">&#8642;</a></th><th>Email<a href="<?php echo $currentFile; ?>?q=ea">&#8639;</a><a href="<?php echo $currentFile; ?>?q=ed">&#8642;</a></th><th>Visit Profile</th></tr>
            <?php
        } else {
            ?>
            <tr><th>Username</th><th>Email</th><th>Visit Profile</th></tr>
            <?php
        }
        if(isset($results)){
            foreach($results as $row) {
                ?>
                <tr>
                    <td><?php echo $row['username']?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><a href="viewuser.php?q=<?php echo $row['ID']?>">User Profile</a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
<?php

require_once "footer.php";