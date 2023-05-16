<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 5/2/2023
 * Time: 5:36 PM
*/

$pageName = "Reviewer Profile";
require_once "header.php";

// Check to see if $_GET['q'] has been set
if (!isset($_GET['q']) || !is_numeric($_GET['q'])) {
    ?>
    <p class="error">There was an error viewing this content.</p>
    <?php
} else {
    $sql = "SELECT * FROM users
            WHERE users.ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $_GET['q']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM books
            WHERE books.userID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $user['ID']);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="user">
        <div class="container">
            <div class="item left_user">
                <table>
                    <tr><th>Username: </th><td class="title"><h4><?php echo $user['username']; ?></h4></td></tr>
                    <tr><th>Email: </th><td><?php echo $user['email']; ?></td></tr>
                    <tr><th>Bio: </th><td><?php echo $user['bio']; ?></td></tr>
                </table>
            </div>
            <div class="item right_user">
                <table>
                    <tr><th>Title</th><th>Visit Review</th></tr>
                <?php
                if(isset($reviews)){
                    foreach($reviews as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row['title']?></td>
                        <td>
                            <a href="viewreview.php?q=<?php echo $row['ID']?>">View</a>
                            <?php if(isset($_SESSION['ID'])) {
                                if ($_SESSION['ID'] == $row['userID'] || $_SESSION['admin'] == 1) {
                                    ?>
                                    <a href="updatereview.php?q=<?php echo $row['ID']?>"> | Update</a> |
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
            </div>
        </div>
    </div>
    <?php

} // End of ifelse statement


require_once "footer.php";