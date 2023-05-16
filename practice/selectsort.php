<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select Sorting Practice - Dynamic Sorting";
require_once "header.php";


// --- Setup 'dynamic sorting' ---
if (isset($_GET['q'])){
    switch ($_GET['q']){
        case "fd":
            $sort = "first_name DESC";
            break;
        case "fa":
            $sort = "first_name";
            break;
        case "ld":
            $sort = "last_name DESC";
            break;
        case "la":
            $sort = "last_name";
            break;
        default:
            $sort = "last_name";
    } // switch statement
} else {
    $sort = "last_name";
} // if $_GET['q'] is set


$sql = "SELECT emp_no, first_name, last_name FROM employees ORDER BY $sort";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<hr>";
?>
<table>
    <tr><th>Options</th><th>First Name <a href="<?php echo $currentFile; ?>?q=fa">&#8639;</a><a href="<?php echo $currentFile; ?>?q=fd">&#8642;</a></th><th>Last Name<a href="<?php echo $currentFile; ?>?q=la">&#8639;</a><a href="<?php echo $currentFile; ?>?q=ld">&#8642;</a></th></tr>
    <?php
    foreach ($results as $row){
        ?>
        <tr>
            <td>
                <a href="selectview.php?q=<?php echo $row['emp_no']?>">View</a> |
                <a href="selectupdate.php?q=<?php echo $row['emp_no']?>">Update</a> |
                <a href="selectdelete.php?q=<?php echo $row['emp_no']?>&l=<?php echo $row['last_name']?>">Delete</a> |
            </td>
            <td><?php echo $row['first_name']?></td><?php echo "\n"; ?>
            <td><?php echo $row['last_name']?></td><?php echo "\n"; ?>
        </tr>
        <?php echo "\n";
    }
    ?>
</table>

require_once "footer.php";