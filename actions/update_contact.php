<?php

/**
 * Update a contact from the database
 * 
 */
session_start();
require_once __DIR__ . '/../config/database.php';
$db = getDatabaseConnection();

// Check if it is a POST request and if id exists and is not empty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    // Sanitizes data
    $id = (int)$_POST['id'];
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $jobTitle = trim($_POST['job_title'] ?? '');
    $departmentId = (int)($_POST['department_id'] ?? 0);

    // Check if phone is filled and if the format is ok 
    if (!empty($phone)) {
        $phoneRegex = '/^(?:(?:\+|00)33|0)[1-9](?:[\s.-]*\d{2}){4}$/';
        if (!preg_match($phoneRegex, $phone)) {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Le numéro de téléphone n\'est pas valide.'
            ];
            header("Location: ../index.php");
            exit();
        }
    } else {
        // if phone is empty store NULL instead of an empty string in the database
        $phone = null;
    }

    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Le format de l\'adresse email n\'est pas valide.'
        ];
        header("Location: ../index.php");
        exit();
    }


    // Check if required data are not empty
    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($jobTitle) && !empty($departmentId)) {
        try {

            // Prepare the query
            $sql = "UPDATE contacts
                    SET first_name = ?, last_name = ?, email = ?, phone = ?, job_title = ?, department_id = ? 
                    WHERE id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$firstName, $lastName, $email, $phone, $jobTitle, $departmentId, $id]);

            // If success then show success toast
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Contact modifié avec succès !'
            ];

            // Redirect to homepage
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            // If fail then show error toast
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Erreur dans la modification du contact.'
            ];
            header("Location: ../index.php");
            exit();
        }
    }
}

header("Location: ../index.php");
exit();
