<?php

/**
 * PDO connection to database
 * 
 * @throws PDOException if the connection fails
 * @return PDO databse connection instance
 */

function getDatabaseConnection(): PDO
{
    $host = 'localhost';
    $dbName = 'contacts_dev';
    $username = 'root';
    $password = '';

    try {
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
