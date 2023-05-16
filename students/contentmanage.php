<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/11/2023
 * Time: 1:12 PM
*/ 

$pageName = "Manage Content";
require_once "header.php";
check_login();

$ID = $_SESSION['ID'];

// Query the data
$sql = "SELECT ID, title, studentID FROM content ORDER BY title";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table>
    <tr><th>Title</th><th>ID</th><th>Options</th></tr>


    <?php
    foreach($result as $row) {
        ?>
        <tr>
            <td><?php echo $row['title']?></td>
            <td><?php echo $row['ID']?></td>
            <td>
                <a href="contentview.php?q=<?php echo $row['ID']?>">View</a> |
                <?php if ($_SESSION['ID'] == $row['studentID']) {
                    ?>
                    <a href="contentupdate.php?q=<?php echo $row['ID']?>">Update</a> |
                    <a href="contentdelete.php?q=<?php echo $row['ID']?>">Delete</a>
                <?php
                } ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<?php
require_once "footer.php";