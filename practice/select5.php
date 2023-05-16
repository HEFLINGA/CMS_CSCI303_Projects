<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select Practice - fetchAll() only what you NEED!";
require_once "header.php";

// Query the data
$sql = "SELECT emp_no, last_name FROM employees ORDER BY last_name";

// Prepares a statement for execution
$stmt = $pdo->prepare($sql);

// Executes a prepared statement
$stmt->execute();

// Fetch : Fetches the next ROW from a RESULT SET. RETURNS AN ARRAY.
// Default : Array indexed by both COLUMN NAME and 0-indexed COLUMN NUMBER.
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<br>";
print_r($result);
echo "<br><br>";
foreach($result as $row) {
    echo $row['emp_no'] . " - " . $row['last_name'] . "<br>";
}



require_once "footer.php";