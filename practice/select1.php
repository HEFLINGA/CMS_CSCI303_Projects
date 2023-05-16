<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select Practice - Foreach Loop";
require_once "header.php";

// Query the data
$sql = "SELECT * FROM employees ORDER BY last_name";

// Execute the query
$result = $pdo->query($sql);

// Loop through and display the results
foreach ($result as $row){
    echo $row['emp_no'] . " - " . $row['last_name'] . "<br>";
}
echo "First loop has ended.";
// Second loop to show that '$result' has nothing in it?
foreach ($result as $row){
    echo $row['emp_no'] . " - " . $row['last_name'] . "<br>";
}
echo "Second loop has ended.";


require_once "footer.php";