<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select Practice - Fetch";
require_once "header.php";

// Query the data
$sql = "SELECT * FROM employees";

// Prepares a statement for execution
$stmt = $pdo->prepare($sql);

// Executes a prepared statement
$stmt->execute();

// Fetch : Fetches the next ROW from a RESULT SET. RETURNS AN ARRAY.
// Default : Array indexed by both COLUMN NAME and 0-indexed COLUMN NUMBER.
$row = $stmt->fetch();
echo "<br>";
print_r($row);
echo "<br><br>";
echo $row['emp_no'] . " - " . $row['last_name'];


require_once "footer.php";