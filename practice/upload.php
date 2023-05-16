<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 3/27/2023
 * Time: 5:24 PM
*/

/*
 *  COPY THIS ENTIRE PAGE OF CODE AFTER YOUR INITIAL COMMENTS -- INCLUDING THESE COMMENTS
 *  CSCI 303 SP 23
 *   ***STOP AND READ CAREFULLY!!!!***
 *      CHANGE THE VARIABLE NAMES THROUGHOUT TO MATCH WHATEVER NAMING CONVENTION YOU NORMALLY USE
 *      $pageName vs $pagename
 *      $showform vs $showForm vs $show_form
 *      $errexists vs $errExists vs $err_exists vs $err
 *      $errfile vs $errFile vs $err_file
 *      etc...
 *      KEEP TRACK THROUGHOUT IF YOU MAKE CHANGES.
 */

//HEADER CODE ========================================================================================
$pageName = "File Uploads";
require_once "header.php";

//SET INITIAL VARIABLES ==============================================================================
$showForm = 1;  // show form is true
$errExists = 0; // initially no errors
$errFile = ""; // initially no error

//FORM PROCESSING ====================================================================================
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // TROUBLE SHOOTING - DISPLAY CONTENTS OF $_FILES
    print_r($_FILES);
    echo "<br>";

    if ($_FILES['myfile']['error'] != 0) {
        $errExists = 1;
        $errFile = "Error uploading file.";
        echo '<br>';
    } else {
        /* **********************************************************************************
         * START HERE - SEE DIRECTIONS PART 1:  DISPLAY THE CONTENTS OF THE $_FILES ARRAY
         * ********************************************************************************** */
        echo "<h3>Part 1 - Contents of FILES Array</h3>";
        echo "<p><strong>Name:</strong> " . $_FILES['myfile']['name'] . "</p>";
        echo "<p><strong>Type:</strong> " . $_FILES['myfile']['type'] . "</p>";
        echo "<p><strong>Temporary Name:</strong> " . $_FILES['myfile']['tmp_name'] . "</p>";
        echo "<p><strong>Error:</strong> " . $_FILES['myfile']['error'] . "</p>";

        /* **********************************************************************************
         * PART 2 - SEE DIRECTIONS PART 2:  USING PHP'S FILE INFORMATION FUNCTIONS
         * ********************************************************************************** */
        echo "<h3>Part 2 - File Information Functions</h3>";
        echo "<strong>Mime Type: </strong>";
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        echo finfo_file($finfo, $_FILES['myfile']['tmp_name']);
        finfo_close($finfo);

        /* **********************************************************************************
         * SEE DIRECTIONS PART 3:  USING THE PATHINFO FUNCTION
         * ********************************************************************************** */
        echo "<h3>Part 3 - Path Info Function</h3>";
        $pinfo = pathinfo($_FILES['myfile']['name']);
        //print_r($pinfo);
        echo "<p><strong>Directory Name:</strong> " . $pinfo['dirname'] . "</p>";
        echo "<p><strong>Basename:</strong> " . $pinfo['basename'] . "</p>";
        echo "<p><strong>Extension:</strong> " . $pinfo['extension'] . "</p>";
        echo "<p><strong>Filename:</strong> " . $pinfo['filename'] . "</p>";

        /* **********************************************************************************
         * SEE DIRECTIONS PART 4:  CREATE FILE NAME
         * ********************************************************************************** */
        echo "<h3>Part 4 - New Filename</h3>";
        $newfile = strtolower("amhefling" . date('YmdHis') . "." . $pinfo['extension']);
        echo "<p><strong>New File:</strong> " . $newfile . "</p>";

        /* **********************************************************************************
         * SEE DIRECTIONS PART 5:  CREATE A FILE PATH
         * ********************************************************************************** */
        echo "<h3>Part 5 - File Path</h3>";
        $filepath = "/var/students/amhefling/csci303sp23/uploads/" . $newfile;
        echo "<p><strong>File Path:</strong> " . $filepath . "</p>";

        /* **********************************************************************************
         * SEE DIRECTIONS PART 6:  CHECK EXISTING
         * ********************************************************************************** */
        if (file_exists($filepath)) {
            $errExists = 1;
            $errFile = "<p class='error'>File already exists.<p>";
        } else {
            /* **********************************************************************************
             * SEE DIRECTIONS PART 7:  MOVING THE FILE
             * ********************************************************************************** */
            if(!move_uploaded_file($_FILES['myfile']['tmp_name'], $filepath)) {
                $errExists = 1;
                $errFile = "File cannot be moved.";
            } // If not moved?
        }//IF ALREADY EXISTS
    }//NO FILE ERROR
    // CONTROL CODE ===================================================================================
    if ($errExists == 1) {
        echo "<p class='error'>Errors Exist!</p>";
    } else {
        echo "<p class='success'>Success!</p>";
        echo "<p>View your file: <a href='/amhefling/csci303sp23/uploads/" . $newfile . "' target='_blank''>" . $newfile . "</a></p>";
    } // else errorExists
}//submit

//DISPLAY FORM =======================================================================================
//REMEMBER TO CHANGE THE $currentFile VARIABLE NAME IF YOU USE A DIFFERENT NAME IN YOUR HEADER!
if ($showForm == 1) {
    ?>
    <h3>Upload File Form</h3>
    <form name="upload" id="upload" method="post" action="<?php echo $currentFile;?>" enctype="multipart/form-data">
        <?php if (!empty($errFile)) {echo "<span class='error'>" . $errFile . "</span>";}?>
        <label for="myfile">Upload Your File:</label><input type="file" name="myfile" id="myfile">
        <br>
        <label for="submit">Submit:</label><input type="submit" name="submit" id="submit" value="UPLOAD">
    </form>
    <?php
}//end showForm

//FOOTER CODE ========================================================================================
require_once "footer.php";
?>