<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 4/25/2023
 * Time: 10:37 AM
*/

// --- Function for checking if there are duplicates ---
function check_duplicates($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':field', $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function check_duplicate_user_review($pdo, $sql, $field1, $field2) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':field1', $field1);
    $stmt->bindValue(':field2', $field2);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

// --- Function for reusing email-sending code ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function send_email($Subject, $Body, $AltBody, $email, $fname) {
    $mail = new PHPMailer(); //Create a new PHPMailer instance
    $mail->Host = 'smtp.gmail.com';//Set the hostname of the mail server
    $mail->SMTPAuth = true;//Whether to use SMTP authentication
    $mail->Username = 'ccucsciweb@gmail.com';//Username to use for SMTP auth - use full email address for gmail
    $mail->Password = 'csci303&409';//Password to use for SMTP authentication
    $mail->SMTPSecure = 'ssl';//Set the encryption
    $mail->Port = 465;//Set the SMTP port number
    $mail->Subject = $Subject;//Set the subject line
    $mail->isHTML(true);//Using HTML Email Body
    $mail->Body = $Body;//Set the Message Body
    $mail->AltBody = $AltBody;
    $mail->setFrom('ccucsciweb@gmail.com', 'CSCI 303 Email Account');//Set who the message is to be sent from
    $mail->addAddress($email, $fname);//Set who the message is to be sent to

    //send the message, check for errors
    return $mail->send();
}

function check_login() {
    if(!isset($_SESSION['ID'])) {
        echo "<p class='error'>This page requires authentication. Please log in to continue!";
        require_once "footer.php";
        exit();
    }
}
function check_admin() {
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        echo "<p class='error'>This page requires admin status. You are not authorized to view this page.";
        require_once "footer.php";
        exit();
    }
}

function check_file_upload($extension) {
    if(strtolower($extension) == "png" || strtolower($extension) == "jpg") {
        return True;
    }
    return False;
}