<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/26/2023
 * Time: 10:24 AM
*/

$pageName = "Add Content";

require_once "header.php";
check_login();

$ID = $_SESSION['ID'];

$show_form = 1;

// Local variables
$error_exists  = 0;
$error_title   = "";
$error_rating = "";
$error_genre = "";
$error_file = "";
$error_comments = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_FILES['myfile']['name'])){
        if ($_FILES['myfile']['error'] != 0) {
            $error_exists = 1;
            $error_file = "Error uploading book cover image.";
        }
    } else {
        $error_exists = 1;
        $error_file = "Missing image file.";
    }

    $title = trim($_POST['title']);
    if (isset($_POST['rating'])){
        $rating = $_POST['rating'];
    }
    if (isset($_POST['genre'])) {
        $genre = $_POST['genre'];
    }
    $comments = $_POST['comments'];
    $added = date("Y-m-d H:i:s");

    // Error checking
    if (empty($title)) {
        $error_exists = 1;
        $error_title = "Missing book title.";
    } else {
        // Check if this specific user already created a review for this title
        $sql = "SELECT * FROM books INNER JOIN users
                ON books.userID = :ID
                WHERE books.title = :title";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ID', $ID);
        $stmt->bindValue(':title', $title);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $error_exists = 1;
            $error_title = "You have already created this review! Please go to reviews to update it if necessary.";
        }
    }
    if (empty($comments)){
        $error_exists = 1;
        $error_comments = "Missing review.";
    }
    if (!isset($rating)){
        $error_exists = 1;
        $error_rating = "Missing rating.";
    }
    if ($genre == "CAG"){
        $error_exists = 1;
        $error_genre = "Missing genre.";
    }

    // Create the file details for upload
    if(!empty($_FILES['myfile']['name'])) {
        $pinfo = pathinfo($_FILES['myfile']['name']);
        if(!check_file_upload($pinfo['extension'])){
            $error_exists = 1;
            $error_file = "Wrong file type. Please upload a PNG or JPG.";
        } else {
            $newfile = strtolower($_SESSION['ID'] . date('YmdHis') . "." . $pinfo['extension']);
            $filepath = "/var/students/amhefling/csci303sp23/uploads/" . $newfile;

            if (file_exists($filepath)) {
                $errExists = 1;
                $errFile = "<p class='error'>File already exists.<p>";
            } else {
                if(!move_uploaded_file($_FILES['myfile']['tmp_name'], $filepath)) {
                    $error_exists = 1;
                    $error_file = "File could not be uploaded.";
                } // If file could not be moved
            }// If file already exists somehow
        }
    }

    if ($error_exists == 1) {
        echo "<p class='error'>There was an error submitting your review. Check below for details.</p>";
    } else {
        $sql = "INSERT INTO books (userID, title, rating, genre, comments, added, imagepath)
                VALUES (:userID, :title, :rating, :genre, :comments, :added, :imagepath)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userID', $ID);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':rating', $rating);
        $stmt->bindValue(':genre', $genre);
        $stmt->bindValue(':comments', $comments);
        $stmt->bindValue(':added', $added);
        $stmt->bindValue(':imagepath', $newfile);
        $stmt->execute();

        $show_form = 0;

        echo "<p class='success'>Review published successfully!</p>";
//        echo "<p>View your file: <a href='/amhefling/csci303sp23/uploads/" . $newfile . "' target='_blank''>" . $newfile . "</a></p>";
    }

}

if($show_form == 1) {
    ?>
    <div class="form_medium">
        <p class="informative">Please fill out the form to submit your review! All fields are required.</p>
        <form name="add" id="add" method="post" action="<?php echo $currentFile; ?>" enctype="multipart/form-data">
            <label class="label_text" for="title">Book Title:</label><br>
            <?php if (!empty($error_title)) { echo "<br><span class='error'>$error_title</span><br><br>"; } ?>
            <input type="text" name="title" id="title"
                   maxlength="255" size="50" placeholder="Book Title"
                   value="<?php if (isset($title)) { echo htmlspecialchars($title); } ?>">
            <br>
            <fieldset>
                <legend class="label_text">Choose a Rating From 0 to 5:</legend>
                <?php if (!empty($error_rating)) { echo "<span class='error'>$error_rating</span><br><br>"; } ?>
                <input type="radio" name="rating" id="rating-ze" value="ze" <?php if (isset($rating) && $rating == "ze") { echo " checked "; } ?>>
                <label for="rating-ze">Zero</label><br>
                <input type="radio" name="rating" id="rating-on" value="on" <?php if (isset($rating) && $rating == "on") { echo " checked "; } ?>>
                <label for="rating-on">One</label><br>
                <input type="radio" name="rating" id="rating-tw" value="tw" <?php if (isset($rating) && $rating == "tw") { echo " checked "; } ?>>
                <label for="rating-tw">Two</label><br>
                <input type="radio" name="rating" id="rating-th" value="th" <?php if (isset($rating) && $rating == "th") { echo " checked "; } ?>>
                <label for="rating-th">Three</label><br>
                <input type="radio" name="rating" id="rating-fr" value="fr" <?php if (isset($rating) && $rating == "fr") { echo " checked "; } ?>>
                <label for="rating-ze">Four</label><br>
                <input type="radio" name="rating" id="rating-fv" value="fv" <?php if (isset($rating) && $rating == "fv") { echo " checked "; } ?>>
                <label for="rating-fv">Five</label><br>
            </fieldset><br>
            <label class="label_text" for="genre">Select a Genre:</label><br>
            <?php if (!empty($error_genre)) { echo "<br><span class='error'>$error_genre</span><br><br>"; } ?>
            <select name="genre" id="genre"><?php
                $sql = "SELECT genrename, genrecode FROM genres ORDER BY priority";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($results as $row){
                    ?><option value="<?php echo $row['genrecode']; ?>" <?php if (isset($genre) && $genre == $row['genrecode']) { echo " selected "; } ?>><?php echo $row['genrename']?></option><?php
                }
                ?>
            </select>
            <br><br>
            <label class='label_text' for="myfile">Upload Book Cover Image:</label><br>
            <?php if (!empty($error_file)) {echo "<br><span class='error'>" . $error_file . "</span><br><br>";}?>
            <input type="file" name="myfile" id="myfile">
            <br><br>
            <label class="label_text" for="comments">Book Summary and Review:</label><br>
            <?php if (!empty($error_comments)) { echo "<br><span class='error'>$error_comments</span><br><br>"; } ?>
            <textarea name="comments" id="comments" placeholder="Summary and Review"><?php if (isset($comments)) { echo $comments; } ?></textarea>
            <br>
            <input type="submit" name="submit" id="submit" value="SUBMIT">
        </form>
    </div>
    <?php
}

require_once "footer.php";