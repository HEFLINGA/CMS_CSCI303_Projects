<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 1/29/2023
 * Time: 4:31 PM
*/

//COPY ALL OF THE CODE ON THIS PAGE *AFTER* YOUR INITIAL COMMENTS
$pageName = "Home";
require_once "header.php";
?>
    <h2 class="functionality">Email Functionality:</h2><br>
    <p class="functionality">Email is sent to the user when updating their profile, and when initially creating the user.</p>
    <br>
    <h2 class="functionality">File Upload Functionality:</h2><br>
    <p class="functionality">The file will be uploaded when a review is published. This file needs to be a png or jpg.<br>
    This can only be an image. The code for this is in the <strong>addreview.php</strong> file. <br>
    This file will be visible on the review screen when viewing the books review.
    </p><br>
    <h2 class="functionality">Additional Functionality:</h2><br>
    <p class="functionality">
        (1) For additional features, I added the ability to view all reviewers, search for one specifically by username, sort
        them by username or email, and view the reviewer/users profile <strong>PHP: displayusers.php</strong>
        (2) This feature also allows users to view a profile page of a user that is clicked on to view. This profile page
        displays the username, email, and bio. It also lists all the reviews the user has published. This list has links
        to view the full review, update the review (if admin or creator) and to delete review (if admin or creator)
        <strong>PHP: viewuser.php</strong>. This page is public, so anyone can view all reviewers. Functions similar to
        the viewing of all content (reviews in my case).
    </p>
<?php
require_once "footer.php";
?>