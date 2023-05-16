<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select Practice - View/Update/Delete Options Population";
require_once "header.php";

// Query the data
$sql = "SELECT emp_no, first_name, last_name FROM employees ORDER BY last_name";

// Prepares a statement for execution
$stmt = $pdo->prepare($sql);

// Executes a prepared statement
$stmt->execute();

// Fetch : Fetches the next ROW from a RESULT SET. RETURNS AN ARRAY.
// Default : Array indexed by both COLUMN NAME and 0-indexed COLUMN NUMBER.
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<br>";
//print_r($result);

// Creating a table
?>
<table>
    <tr><th>Options</th><th>First Name</th><th>Last Name</th></tr>


<?php
// Display the single result to the screen.
// Loop through the results and display to the screen.

foreach($result as $row) {
    ?>
    <tr>
        <td>
            <a href="selectview.php?q=<?php echo $row['emp_no']?>">View</a> |
            <a href="selectupdate.php?q=<?php echo $row['emp_no']?>">Update</a> |
            <a href="selectdelete.php?q=<?php echo $row['emp_no']?>&l=<?php echo $row['last_name']?>">Delete</a> |
        </td>
        <td><?php echo $row['first_name']?></td>
        <td><?php echo $row['last_name']?></td>
    </tr>
    <?php
}
?>
</table>

<?php
require_once "footer.php";