<?php

/**
 * Update a contact from the database
 * 
 */

require_once __DIR__ . '/../config/database.php';
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $id = (int)$_POST['id'];
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $jobTitle = trim($_POST['job_title']);
    $departmentId = (int)$_POST['department_id'];


    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($jobTitle) && !empty($departmentId)) {
        try {

            $sql = "UPDATE contacts
                    SET first_name = ?, last_name = ?, email = ?, phone = ?, job_title = ?, department_id = ? 
                    WHERE id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$firstName, $lastName, $email, $phone, $jobTitle, $departmentId, $id]);

            header("Location: ../index.php?updated=1");
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de la modification du contact : " . $e->getMessage());
        }
    }
}

header("Location: ../index.php");
exit();
