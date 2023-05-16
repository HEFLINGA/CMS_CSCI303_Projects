<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 2/27/2023
 * Time: 10:30 AM
*/

$pageName = "Select - Search Employees Tutorial";
require_once "header.php";
?>

<!--Search form-->
<p>Please enter the first of the employee you are looking for: </p>
<form name="mysearch" id="mysearch" method="get" action="<?php echo $currentFile; ?>">
    <label for="term">Search Employee First Name:</label>
    <input type="search" id="term" name="term" placeholder="Search...">
    <input type="submit" id="search" name="search" value="Search">
</form>

<?php
if(isset($_GET['search'])) {
    if (empty($_GET['term'])) {
        echo "<p class='error'>The search field was empty! Please type in your search into the search bar.</p>";
    } else {
        $term = trim($_GET['term']) . "%";
        $sql = "SELECT first_name, last_name FROM employees WHERE first_name LIKE :term ORDER BY last_name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            echo "<p class='error'>There are no results for " . htmlspecialchars($_GET['term']) . ". Please try another search.</p>";
        } else {
            echo "<p class='success'>Here are the search results:</p>";
            foreach ($results as $row) {
                echo $row['first_name'] . " " . $row['last_name'] . "<br>";
            }
        } // if results 'empty'
    } // if search 'empty'
} // if 'isset'

require_once "footer.php";