<?php

/*
 * Class: csci303sp23
 * User: amhefling
 * Date: 1/29/2023
 * Time: 4:26 PM
*/

function check_duplicates($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':field', $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}