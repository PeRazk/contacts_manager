<?php

/**
 * Delete a contact from the database
 * 
 */

require_once __DIR__ . '/../config/database.php';
$db = getDatabaseConnection();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $sql = "DELETE FROM contacts WHERE id = ?";

        $stmt = $db->prepare($sql);

        $stmt->execute([$id]);

        header("Location: ../index.php?deleted=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression du contact : " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
