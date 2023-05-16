<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select Practice - View emp through options or list";
require_once "header.php";

// Check to see if $_GET['q'] is set.
if (!isset($_GET['q']) || !is_numeric($_GET['q'])) {
    ?>
        <p class="error">There was an error displaying the data.</p>
        <p>Back to the options menu: <a href="selectoptions.php">PDO Q - View/Delete/Update options</a></p>
        <p>Back to the list menu: <a href="selectlist.php">PDO Q - List of employees</a></p>
    <?php
} else {

    // Query the data
    $sql = "SELECT * FROM employees WHERE emp_no = :emp_no";

    // Prepares a statement for execution
    $stmt = $pdo->prepare($sql);


    // ------- NEW STUFF --------
    // Binds the actual value of $_GET['q'] to placeholder for employee number
    $stmt->bindValue(':emp_no', $_GET['q']);
    // ----- END NEW STUFF ------


    // Executes a prepared statement
    $stmt->execute();

    // Fetch : Fetches the next ROW from a RESULT SET. RETURNS AN ARRAY.
    // Default : Array indexed by both COLUMN NAME and 0-indexed COLUMN NUMBER.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // ------- NEW STUFF --------
    // Display the single result to the screen
    ?>

    <table>
        <tr><th>Employee ID: </th><td><?php echo $row['emp_no']; ?></td></tr>
        <tr><th>Birth Date: </th><td><?php echo $row['birth_date']; ?></td></tr>
        <tr><th>First Name: </th><td><?php echo $row['first_name']; ?></td></tr>
        <tr><th>Last Name: </th><td><?php echo $row['last_name']; ?></td></tr>
        <tr><th>Gender: </th><td><?php echo $row['gender']; ?></td></tr>
        <tr><th>Hire Date: </th><td><?php echo $row['hire_date']; ?></td></tr>
    </table>

    <?php

} // End get q if statement
// ----- END NEW STUFF ------

require_once "footer.php";