<?php

/**
 * Delete a contact from the database
 * 
 */
session_start();
require_once __DIR__ . '/../config/database.php';
$db = getDatabaseConnection();

// Check if id exists and is not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        // Prepare the query
        $sql = "DELETE FROM contacts WHERE id = ?";

        $stmt = $db->prepare($sql);

        // Execute the query
        $stmt->execute([$id]);

        // If success then show success toast
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Contact supprimé avec succès !'
        ];

        // Redirect to homepage
        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        // If fail then show error toast
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Erreur lors de la suppression du contact.'
        ];
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
