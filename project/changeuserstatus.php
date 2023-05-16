<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/29/2023
 * Time: 6:46 PM
*/

$pageName = "Users Status";
require_once "header.php";
check_admin();

if(isset($_GET['q'])) {
    switch ($_GET['a']){
        case 0:
            $admin = 1;
            break;
        case 1:
            $admin = 0;
            break;
        default:
            $admin = 0;
    }

    // Type your code to UPDATE the user in the database here
    $sql = "UPDATE users
                SET admin = :admin
                WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ID', $_GET['q']);
    $stmt->bindValue(':admin', $admin);
    $stmt->execute();
}

$sql = "SELECT *
FROM users
ORDER BY username";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table class="userstatus">
    <tr><th>Username</th><th>Email</th><th>Admin Status</th></tr>
    <?php
    if(isset($results)){
        foreach($results as $row) {
            ?>
            <tr>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['admin'] ?> |
                    <a href="changeuserstatus.php?q=<?php echo $row['ID']?>&a=<?php echo $row['admin']?>">CHANGE</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>
<?php

require_once "footer.php";