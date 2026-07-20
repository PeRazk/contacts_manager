<?php

/**
 * Add a new contact into the database
 * 
 */

require_once __DIR__ . '/../config/database.php';
$db = getDatabaseConnection();

// Check if it is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the data from the form and satinatizes it
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
    $jobTitle = isset($_POST['job_title']) ? trim($_POST['job_title']) : '';
    $departmentId = isset($_POST['department_id']) ? (int)$_POST['department_id'] : 0;

    // Check if phone is filled and if the format is ok 
    if (!empty($phone)) {
        $phoneRegex = '/^(?:(?:\+|00)33|0)[1-9](?:[\s.-]*\d{2}){4}$/';
        if (!preg_match($phoneRegex, $phone)) {
            die("Erreur : Le numéro de téléphone n'est pas valide.");
        }
    } else {
        // if phone is empty store NULL instead of an empty string in the database
        $phone = null;
    }

    // Check if all required fields are filled
    if (empty($firstName) || empty($lastName) || empty($email) || empty($jobTitle) || empty($departmentId)) {
        die("Erreur : Tous les champs obligatoires doivent être remplis.");
    }

    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : Le format de l'adresse email n'est pas valide.");
    }

    try {
        // Prepare the query
        $sql = "INSERT INTO contacts (first_name, last_name, email, phone, job_title, department_id) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($sql);

        // Execute the query with the sanitized values
        $stmt->execute([
            $firstName,
            $lastName,
            $email,
            $phone,
            $jobTitle,
            $departmentId
        ]);

        // Redirect to main page with a success
        header("Location: ../index.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout du contact : " . $e->getMessage());
    }
} else {
    // Redirect to main page if it is not a POST request
    header("Location: ../index.php");
    exit();
}
